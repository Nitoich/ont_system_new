<template>
    <div v-if="entity_config" class="bg-white p-2">
        <div v-if="entity_config" class="flex justify-between">
            <h1 class="text-xl">Раздел с сущностью {{ entity_config.name }}</h1>
            <StandardButton @click="state_show_popup_fast_create = true" label="Создать"></StandardButton>
        </div>
        <div class="sticky top-0 bg-white py-2 border-b-2 z-10">
            <EntityFilter
                v-model="filter_values"
                :entity="entity"
            ></EntityFilter>
            <div class="flex justify-between items-center bg-white">
                <DefaultPagination
                    v-if="entity_pagination"
                    :pagination-meta="entity_pagination"
                    @click="paginationClick"
                ></DefaultPagination>
                <p>Всего выбрано записей: {{ countSelectedItems() }}</p>
                <div v-if="entity_pagination" class="options">
                    <label for="records_per_page">Кол-во записей на странице:</label>
                    <select @click="savePerPageOption" v-model="items_per_page" id="records_per_page">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="space-y-1.5 border-l-2 border-r-2">
            <SmartTable
                :link-columns="linkColumns"
                :headers="getHeaders()"
                :items="entity_items"
                :can-select="true"
                v-model="selectedItems"
            ></SmartTable>
        </div>
        <div class="group-actions sticky bottom-0 py-2 border-t-2 bg-white">
            <div class="flex justify-between">
                <select class="flex-1" id="group-action">
                    <option value="delete">Удалить</option>
                </select>
                <ButtonGroup
                    :buttons="[
                        {
                            name: 'Выполнить для выбранных',
                            cb: () => {}
                        },
                        {
                            name: 'Выполнить для всех',
                            cb: () => {}
                        }
                    ]"
                ></ButtonGroup>
            </div>
        </div>
        <Popup
            v-model="state_show_popup_fast_create"
            :props="{ entity }"
            :component="fast_create_component"
        ></Popup>
    </div>
</template>

<script>
import Filter from "../../../../Components/Filter.vue";
import SmartTable from "../../../../Components/SmartTable.vue";
import DefaultPagination from "../../../../Components/Pagination/DefaultPagination.vue";
import StandardButton from "../../../../Components/Buttons/StandardButton.vue";
import Popup from "../../components/Popup.vue";
import FastCreateEntity from "./FastCreateEntity.vue";
import { mapGetters } from "vuex";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
import EntityFilter from "./EntityFilter.vue";

export default {
    name: "AllItemsEntity",
    data: () => ({
        entity_config: null,
        entity_items: [],
        entity_pagination: {},
        filter_values: {},
        items_per_page: 10,
        fast_create_component: FastCreateEntity,
        state_show_popup_fast_create: false,
        linkColumns: {},
        selectedItems: [],
        selected_items_in_pages: {},
        current_page_link: ``
    }),
    mounted() {
        new Promise(async (resolve, reject) => {
            await this.$store.dispatch('validateEntity', this.entity);
            resolve();
        }).then(() => { this.init(); });
    },
    methods: {
        init() {
            this.current_page_link = ``;
            this.selectedItems = [];
            this.selected_items_in_pages = {};
            this.entity_config = this.entities[this.entity];
            let options = localStorage.getItem('per_page_options');
            if(!options) { this.items_per_page = 10; }
            else {
                options = JSON.parse(options);
                if(!options[this.entity]) { this.items_per_page = 10; }
                else { this.items_per_page = options[this.entity]; }
            }
            if(this.is_auth) {
                this.getItems().then(response => {
                    this.current_page_link = this.entity_pagination.links[1].url;
                });
            }

            this.fast_create_component = FastCreateEntity;
            this.getLinkColumns()
            // this.current_page_link = `/api/v1/${this.entity}?page=1&per_page=${this.items_per_page}`;

            if(this.entity_config.newFastCreateComponent) {
                this.fast_create_component = this.entity_config.newFastCreateComponent;
            }
        },
        getLinkColumns() {
            const result = {};
            result[this.entity_config.primary_field] = (item) => `/admin/${this.entity}/${item[this.entity_config.primary_field]}`;
            this.$store.dispatch('getReferencesFields', this.entity)
                .then((response) => {
                    for(const [key, value] of Object.entries(response)) {
                        let index = value.type.indexOf(':');
                        result[key] = (item) => `/admin/${value.type.slice(index + 1)}/${item[value.reference_field]}`;
                    }
                    this.linkColumns = { ...result };
                })
            return result;
        },
        savePerPageOption() {
            let options = localStorage.getItem('per_page_options');
            if(!options) {
                localStorage.setItem('per_page_options', JSON.stringify({}));
                options = '{}';
            }
            options = JSON.parse(options);
            options[this.entity] = this.items_per_page;
            localStorage.setItem('per_page_options', JSON.stringify(options));
        },
        paginationClick(event, link) {
            this.saveSelectedItemsByPageLink(this.current_page_link);
            this.$set(this, 'selectedItems', this.getSelectedItemsByPageLink(link.url));
            this.$set(this, 'current_page_link', link.url);
            this.getItems(this.filter_values, link.url);
        },
        saveSelectedItemsByPageLink(url) {
            this.selected_items_in_pages[url] = this.selectedItems;
        },
        getSelectedItemsByPageLink(url) {
            const result = this.selected_items_in_pages[url];
            if(typeof result === 'undefined') { return []; }
            return result;
        },
        mapEntityFields(cb) {
            if(!this.entity_config) { return {}; }
            const fields = this.entity_config.fields;
            const result = {};
            for(const [key, value] of Object.entries(fields)) {
                result[key] = cb(value);
            }
            return result;
        },
        getHeaders() {
            const headers = this.mapEntityFields((field) => field.name);
            const result = {};
            for(const [key, value] of Object.entries(headers)) {
                if(this.entity_config.fields[key].hidden != true) {
                    result[key] = value;
                }
            }
            return result;
        },
        prepareFilterFields() {
            const result = {};
            for(const [key, field] of Object.entries(this.entity_config.fields)) {

                if(field.hidden == true) {
                    continue;
                }

                if(field.type.includes('entity:')) {
                    result[field.reference_field] = {
                        name: field.name,
                    };
                    continue;
                }

                result[key] = {
                    name: field.name
                };
            }
            return result;
        },
        countSelectedItems() {
            let count = 0;
            for(const [key, value] of Object.entries(this.selected_items_in_pages)) {
                count += value.length;
            }
            return count;
        },
        getItems(filter = {}, link = null) {
            return this.$store.dispatch('getEntityItems', { entity: this.entity, filter: Object.assign(filter, { per_page: this.items_per_page }), link})
                .then((response) => {
                    this.entity_items = response.data.data;
                    this.entity_pagination = response.data.meta;
                });
        }
    },
    watch: {
        filter_values() {
            this.$set(this, 'selected_items_in_pages', {});
            this.$set(this, 'selectedItems', []);
            this.getItems(this.filter_values);
        },
        items_per_page() {
            this.getItems(this.filter_values);
        },
        entity() {
            this.init();
        },
        selectedItems() {
            if(this.current_page_link !== '') {
                this.saveSelectedItemsByPageLink(this.current_page_link);
            }
        },
        state_show_popup_fast_create() {
            if(!this.state_show_popup_fast_create) {
                this.getItems(this.filter_values)
            }
        }
    },
    props: {
        entity: {
            type: String,
        }
    },
    computed: {
        ...mapGetters([
            'entities',
            'is_auth'
        ])
    },
    components: {
        EntityFilter,
        ButtonGroup,
        SmartTable,
        'v-filter': Filter,
        DefaultPagination,
        StandardButton,
        Popup
    }
}
</script>

<style scoped>

</style>
