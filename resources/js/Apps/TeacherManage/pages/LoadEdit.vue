<template>
    <div v-if="load" class="container mx-auto flex flex-col gap-3 items-center">
        <div class="fields">
            <div :key="key" v-for="(field, key) in this.fields" class="field grid grid-cols-2 items-center">
                <div class="name text-right">{{ field.name }}</div>
                <text-input v-if="!field.type" v-model="load[key]" :disabled="field.disabled ? false : field.disabled"></text-input>
                <smart-select v-model="load[key]" :items="field.items" v-if="field.type && field.type.toLowerCase() == 'select'"></smart-select>
            </div>
        </div>
        <standard-button @click="save" label="Сохранить"></standard-button>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import TextInput from "../components/Inputs/TextInput";
import SmartSelect from "../components/SmartSelect";

export default {
    name: "LoadEdit",
    data: () => ({
        load: undefined,
        fields: {
            id: {
                name: 'ID:',
                disabled: true,
            },
            group_id: {
                name: 'Группа:',
                items: {},
                type: 'select'
            },
            hours: {
                name: 'Кол-во часов:'
            },
            semester_id: {
                name: 'Семестр:'
            },
            type: {
                name: 'Тип:'
            }
        }
    }),
    methods: {
        save() {
            alert('saving...');
        }
    },
    watch: {
        async is_auth() {
            this.load = await this.$store.dispatch('getLoad', this.$route.params.id);
            await this.$store.dispatch('getGroups');
            this.fields.group_id.items = this.groups_for_select;
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'groups_for_select'
        ])
    },
    components: {
        TextInput,
        SmartSelect
    }
}
</script>

<style scoped>

</style>
