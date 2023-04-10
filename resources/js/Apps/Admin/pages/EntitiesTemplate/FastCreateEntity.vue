<template>
    <div class="space-y-1.5">
        <div class="title">
            <h1 class="text-xl text-center">Создать новую {{ entity_config.name }}</h1>
        </div>

        <div class="fields space-y-1.5" v-if="entity_config && entity_fields_values">
            <template v-for="(field, key) in entity_fields">
                <TextInput v-if="field.type === 'string' && conditionsForDrawField(field)" :placeholder="field.name" v-model="entity_fields_values[key]"></TextInput>
                <EntitySelector v-if="field.type.includes('entity:') && conditionsForDrawField(field)" :placeholder="field.name" :entity="field.reference_enitity" v-model="entity_fields_values[field.reference_field]"></EntitySelector>
                <SmartSelect v-if="field.type === 'select'" :placeholder="field.name" :items="field.items" v-model="entity_fields_values[key]"></SmartSelect>
                <DatePicker v-if="field.type === 'date'" :placeholder="field.name" v-model="entity_fields_values[key]"></DatePicker>
            </template>
        </div>

        <div v-if="error" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">{{ error.message }}</span>
                <ul v-if="typeof error.errors !== 'undefined'" class="mt-1.5 ml-4 list-disc list-inside">
                    <li v-for="err in error.errors">{{ err[0] }}</li>
                </ul>
            </div>
        </div>

        <div class="btns flex justify-center">
            <ButtonGroup
                :buttons="[
                    {
                        name: 'Создать',
                        cb: create
                    },
                    {
                        name: 'Отмена',
                        cb: cancel
                    }
                ]"
            ></ButtonGroup>
        </div>
    </div>
</template>

<script>
import TextInput from "../../../../Components/Inputs/TextInput.vue";
import { mapGetters } from "vuex";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
import http from "../../http";
import SmartSelect from "../../components/Inputs/SmartSelect.vue";
import EntitySelector from "../../components/EntitiesComponents/EntitySelector.vue";
import DatePicker from "../../components/Inputs/DatePicker.vue";
export default {
    name: "FastCreateEntity",
    data: () => ({
        entity_config: null,
        entity_fields: null,
        entity_fields_values: null,
        error: null
    }),
    methods: {
        conditionsForDrawField(field) {
            if(typeof field.writable !== 'undefined' || field.writable === false) {
                return false;
            }

            if(field.hidden == true) {
                return false;
            }

            if(field.type.includes('entity:')) {
                field.items = {test: 'test'};
                let index = field.type.indexOf(':');
                field.reference_enitity = field.type.slice(index + 1);
                return true;
            }

            return true;
        },
        create() {
            this.$store.dispatch('createEntityItem', {
                entity: this.entity,
                data: this.entity_fields_values
            })
                .then((response) => {
                    window.notify({
                        type: 'success',
                        content: `
                            <p>Сущность "${this.entity_config.name}" успешно создана!</p>
                            <a style="text-decoration: underline" href="/admin/${this.entity}/${response.data.data[this.entity_config.primary_field]}">Перейти к сущности...</a>
                        `
                    });
                    this.cancel();
                })
                .catch(({ response }) => {
                    if(response.status >= 400 && response.status < 500) {
                        this.error = response.data.error;
                    }
                })
        },
        cancel() {
            this.$emit('close-popup');
        }
    },
    created() {
        this.entity_config = this.entities[this.entity];
        this.entity_fields = this.entity_config.fields;
    },
    mounted() {
        Object.keys(this.entity_fields).forEach((key) => {
            this.entity_fields_values = {};
            this.$set(this.entity_fields_values, key, '');
        });
    },
    props: {
        entity: {
            type: String
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'entities'
        ])
    },
    components: {
        DatePicker,
        EntitySelector,
        SmartSelect,
        ButtonGroup,
        TextInput
    }
}
</script>

<style scoped>

</style>
