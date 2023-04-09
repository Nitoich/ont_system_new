<template>
    <SmartSelect
        :items="preparedItems"
        v-model="value"
        @focus="focus"
        @input=""
        :placeholder="this.placeholder"
        :item-loader="loader"
    ></SmartSelect>
</template>

<script>
import SmartSelect from "../../components/Inputs/SmartSelect.vue";
import {mapGetters} from "vuex";
export default {
    name: "EntitySelector",
    data: () => ({
        entity_config: null,
        entity_fields: null,
        entity_items: [],
        loader: false
    }),
    created() {
        this.init();
        this.getItems()
    },
    methods: {
        init() {
            this.entity_config = this.entities[this.entity];
            this.entity_fields = this.entity_config.fields;
        },
        focus() {
            this.getItems();
        },
        getItems() {
            this.loader = true;
            this.$store.dispatch('getEntityItems', {
                entity: this.entity,
                filter: {
                    pagination: false
                }
            })
                .then(response => {
                    this.entity_items = response.data.data;
                    this.loader = false;
                });
        }
    },
    props: {
        entity: {
            type: String
        },
        value: {
            type: [String, Number, null],
            default: ''
        },
        placeholder: {
            type: String,
            default: ''
        }
    },
    watch: {
        value() {
            this.$emit('input', this.value);
        }
    },
    computed: {
        ...mapGetters([
            'entities'
        ]),
        preparedItems() {
            return this.entity_items.reduce((res, item) => (res[item[this.entity_config.primary_field]] = item[this.entity_config.name_field], res), {});
        }
    },
    components: {SmartSelect}
}

</script>

<style scoped>

</style>
