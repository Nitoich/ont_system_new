<template>
    <div class="filter relative py-1 z-[999]">
        <div @click="focus" class="accepted-filters flex gap-2 p-2 min-h-[40px] max-w-full border-2 border-slate-600 overflow-auto">
            <div v-for="(field, key) in this.acceptedFields" class="accepted-field p-1.5 bg-main-blue rounded-lg">
                <span class="whitespace-nowrap">{{ field.name }}: {{ field.value }}</span>
            </div>
        </div>
        <div style="display: none" ref="fieldsContainer" class="fields absolute top-100 w-full h-max py-1 px-2 bg-white border-2 z-[]">
            <div class="fields overflow-y-auto max-h-[300px]">
                <div v-for="(field, key) in this.fields" class="field flex items-center gap-2">
                    <span>{{ field.name }}:</span>
                    <text-input v-model="fieldsValues[key]" v-if="typeof field.type == 'undefined' || field.type.toLowerCase() === 'text'"></text-input>
                    <smart-select v-model="fieldsValues[key]" v-if="typeof field.type !== 'undefined' && field.type.toLowerCase() == 'select'" :items="field.items"></smart-select>
                    <input v-model="fieldsValues[key]" v-if="typeof field.type !== 'undefined' && field.type.toLowerCase() == 'date'" type="date">
                </div>
            </div>
            <standard-button @click="accept" label="Применить"></standard-button>
            <standard-button @click="reset" label="Сброс"></standard-button>
            <standard-button @click="cancel" label="Отменить"></standard-button>
        </div>

    </div>
</template>

<script>
import textInput from "./Inputs/TextInput";
import smartSelect from "./SmartSelect";

export default {
    name: "vFilter",
    created() {
        for(const [key, value] of Object.entries(this.fields)) {
            this.$set(this.fieldsValues, key, value.value ?? null);
        }
    },
    data: () => ({
        fieldsValues: {}
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
        textInput,
        smartSelect
    },
    props: {
        value: {},
        fields: {}
    },
    computed: {
        acceptedFields() {
            const returnValues = {};
            for(const [key, value] of Object.entries(this.fieldsValues)) {
                if(value) {
                    returnValues[key] = Object.assign(this.fields[key], { value: this.fieldsValues[key] });
                }
            }
            return returnValues;
        }
    }
}
</script>

<style scoped>

</style>
