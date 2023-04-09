<template>
    <div class="filter relative py-1 z-[999]">
        <div @click="focus" class="accepted-filters flex gap-2 p-2 min-h-[40px] max-w-full border-2 border-slate-600 overflow-auto">
            <div v-for="(field, key) in this.acceptedFields" class="accepted-field p-1.5 bg-main-blue rounded-lg">
                <span class="whitespace-nowrap">{{ field.name }}: {{ field.value }}</span>
            </div>
        </div>
        <div style="display: none" ref="fieldsContainer" class="fields absolute top-100 w-full h-max py-1 px-2 bg-white border-2 z-[]">
            <div class="fields overflow-y-auto max-h-[300px]">
                <div v-for="(field, key) in entity_fields" class="field flex items-center gap-2">
                    <text-input :placeholder="field.name" v-model="fieldsValues[key]" v-if="typeof field.type == 'undefined' || field.type.toLowerCase() === 'string'"></text-input>
                    <EntitySelector :placeholder="field.name" v-model="fieldsValues[key]" v-if="field.type.includes('entity:')" :entity="field.type.replace('entity:', '')"></EntitySelector>
<!--                    <input v-model="fieldsValues[key]" v-if="typeof field.type !== 'undefined' && field.type.toLowerCase() == 'date'" type="date">-->
                </div>
            </div>
            <ButtonGroup
                :buttons="[
                    {
                        name: 'Применить',
                        cb: accept
                    },
                    {
                        name: 'Сброс',
                        cb: reset
                    },
                    {
                        name: 'Отменить',
                        cb: cancel
                    }
                ]"
            ></ButtonGroup>
        </div>
    </div>
</template>

<script>
import textInput from "../../../../Components/Inputs/TextInput.vue";
import EntitySelector from "../../components/EntitiesComponents/EntitySelector.vue";
import {mapGetters} from "vuex";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";

export default {
    name: "EntityFilter",
    created() {
        for(const [key, value] of Object.entries(this.entity_fields)) {
            this.$set(this.fieldsValues, key, value.value ?? null);
        }
    },
    data: () => ({
        fieldsValues: {},
    }),
    methods: {
        pageEventClick(event) {
            const withinBoundaries = event.composedPath().includes(this.$el);
            if(!withinBoundaries) {
                this.accept();
                this.blur();
            }
        },
        focus() {
            document.addEventListener('click', this.pageEventClick);
            this.$refs.fieldsContainer.style.display = 'block';
        },
        blur() {
            document.removeEventListener('click', this.pageEventClick);
            this.$refs.fieldsContainer.style.display = 'none';
        },
        accept() {
            const values = {};
            for(const [key, field] of Object.entries(this.acceptedFields)) {
                this.$set(values, key, field.value);
            }
            this.$emit('input', values);
            this.blur();
        },
        reset() {
            this.clearAllValues();
            this.accept();
        },
        clearAllValues() {
            for(const [key, value] of Object.entries(this.fieldsValues)) {
                this.$set(this.fieldsValues, key, null);
            }
        },
        cancel() {
            this.clearAllValues();
            for(const [key, value] of Object.entries(this.value)) {
                this.$set(this.fieldsValues, key, value);
            }
            this.accept();
        }
    },
    components: {
        ButtonGroup,
        EntitySelector,
        textInput,
    },
    props: {
        value: {},
        entity: {}
    },
    computed: {
        acceptedFields() {
            const returnValues = {};
            for(const [key, value] of Object.entries(this.fieldsValues)) {
                if(value) {
                    returnValues[key] = Object.assign(this.entity_fields[key], { value: this.fieldsValues[key] });
                }
            }
            return returnValues;
        },
        entity_fields() {
            const result = {};
            for(const [key, field] of Object.entries(this.entities[this.entity].fields)) {

                if(field.hidden == true) {
                    continue;
                }

                if(field.type.includes('entity:')) {
                    result[field.reference_field] = field;
                    continue;
                }

                result[key] = field
            }
            return result;
        },
        ...mapGetters([
            'entities'
        ])
    }
}
</script>

<style scoped>

</style>
