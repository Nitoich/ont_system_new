<template>
    <div class="space-y-1.5">
        <div class="title">
            <h1 class="text-xl text-center">Создать новую {{ entity_config.name }}</h1>
        </div>

        <div class="fields space-y-1.5" v-if="entity_config && entity_fields_values">
            <TextInput v-if="(typeof field.writable === 'undefined') || (field.writable == true)" :key="key" v-for="(field, key) in entity_fields" :placeholder="field.name" v-model="entity_fields_values[key]"></TextInput>
        </div>

        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    <li>At least 10 characters (and up to 100 characters)</li>
                    <li>At least one lowercase character</li>
                    <li>Inclusion of at least one special character, e.g., ! @ # ?</li>
                </ul>
            </div>
        </div>

        <div class="btns flex justify-center">
            <ButtonGroup
                :buttons="[
                    {
                        name: 'Создать',
                        cb: () => {}
                    },
                    {
                        name: 'Отмена',
                        cb: () => {}
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
export default {
    name: "FastCreateEntity",
    data: () => ({
        entity_config: null,
        entity_fields: null,
        entity_fields_values: null
    }),
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
        ButtonGroup,
        TextInput
    }
}
</script>

<style scoped>

</style>
