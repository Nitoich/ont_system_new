<template>
    <div v-if="entity_config" class="bg-white p-2">
        <div v-if="entity_config" class="flex justify-between">
            <h1 class="text-xl">Раздел с сущностью {{ entity_config.name }}</h1>
            <StandardButton @click="state_show_popup_fast_create = true" label="Создать"></StandardButton>
        </div>
        <div class="sticky top-0 bg-white py-2 border-b-2">
            <v-filter
                :fields="prepareFilterFields()"
                v-model="filter_values"
            ></v-filter>
            <div class="flex justify-between items-center bg-white">
                <DefaultPagination
                    :pagination-meta="entity_pagination"
                    @click="paginationClick"
                ></DefaultPagination>
                <div class="options">
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
                :link-columns="linkColumns()"
                :headers="getHeaders()"
                :items="entity_items"
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

export default {
    name: "AllItemsEntity",
    data: () => ({
        entity_config: null,
        entity_items: [],
        entity_pagination: {},
        filter_values: {},
        items_per_page: 10,
        fast_create_component: FastCreateEntity,
        state_show_popup_fast_create: false
    }),
    async created() {
        await this.$store.dispatch('validateEntity', this.entity);
    },
    mounted() {
        this.entity_config = this.entities[this.entity];
        let options = localStorage.getItem('per_page_options');
        if(!options) { this.items_per_page = 10; }
        else {
            options = JSON.parse(options);
            if(!options[this.entity]) { this.items_per_page = 10; }
            else { this.items_per_page = options[this.entity]; }
        }
        if(this.is_auth) {
            this.getItems();
        }

        if(this.newFastCreateComponent) {
            this.fast_create_component = this.newFastCreateComponent;
        }
    },
    methods: {
        linkColumns() {
            const result = {};
            result[this.entity_config.primary_field] = (item) => `/admin/${this.entity}/${item[this.entity_config.primary_field]}`;
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
            this.getItems(this.filter_values, link.url);
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
            return this.mapEntityFields((field) => field.name);
        },
        prepareFilterFields() {
            return this.mapEntityFields((field) => ({
                name: field.name
            }))
        },
        getItems(filter = {}, link = null) {
            this.$store.dispatch('getEntityItems', { entity: this.entity, filter: Object.assign(filter, { per_page: this.items_per_page }), link})
                .then((response) => {
                    this.entity_items = response.data.data;
                    this.entity_pagination = response.data.meta;
                });
        }
    },
    watch: {
        filter_values() {
            this.getItems(this.filter_values);
        },
        items_per_page() {
            this.getItems(this.filter_values);
        }
    },
    props: {
        entity: {
            type: String,
        },
        newFastCreateComponent: {
            type: [Object],
            default: null
        }
    },
    computed: {
        ...mapGetters([
            'entities',
            'is_auth'
        ])
    },
    components: {
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
