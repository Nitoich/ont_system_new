<template>
    <div v-if="load" class="container mx-auto flex flex-col gap-3 items-center justify-center h-screen">
        <div @click="$router.back()" class="cross absolute right-1 top-2 w-[50px] h-[50px] cursor-pointer">
            <span class="rotate-45 block absolute w-[10px] h-[30px] bg-slate-500"></span>
            <span class="-rotate-45 block absolute w-[10px] h-[30px] bg-slate-500"></span>
        </div>
        <div class="fields">
            <div :key="key" v-for="(field, key) in this.fields" class="field grid grid-cols-2 items-center">
                <div class="name text-right">{{ field.name }}</div>
                <text-input v-if="!field.type" v-model="load[key]" :disabled="typeof field.disabled === 'undefined' ? false : field.disabled"></text-input>
                <smart-select v-model="load[key]" :items="field.items" v-if="field.type && field.type.toLowerCase() == 'select'"></smart-select>
            </div>
        </div>
        <div class="flex flex-row gap-1">
            <standard-button @click="saveAndExit" label="Сохранить"></standard-button>
            <standard-button @click="save" label="Применить"></standard-button>
            <danger-button @click="$router.back()" label="Отменить"></danger-button>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import TextInput from "../../../Components/Inputs/TextInput";
import SmartSelect from "../../../Components/SmartSelect";

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
                name: 'Тип:',
                type: 'select',
                items: {
                    load: 'Нагрузка',
                    vacancy: 'Вакансия'
                }
            }
        }
    }),
    mounted() {
        if(this.is_auth) {
            this.loadData();
        }
    },
    methods: {
        async save() {
           await this.$store.dispatch('updateLoad', this.load)
               .then(response => {
                   console.log(response);
               })
               .catch(err => {
                   console.log(err.response)
               })
        },
        async saveAndExit() {
            await this.save();
            this.$router.back();
        },
        async loadData() {
            this.load = await this.$store.dispatch('getLoad', this.$route.params.id);
            await this.$store.dispatch('getGroups', {
                params: {
                    pagination: false
                }
            });
            this.fields.group_id.items = this.groups_for_select;
        }
    },
    watch: {
        async is_auth() {
            await this.loadData();
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
