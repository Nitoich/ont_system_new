<template>
    <div v-if="this.is_auth" class="container mx-auto">
        <div class="filter flex flex-row gap-3">
            <text-input v-model="filter.id" placeholder="ID"></text-input>
            <text-input v-model="filter.semester_id" placeholder="Номер семестра"></text-input>
            <standard-button @click="$store.dispatch('getLoads', filter)" label="Применить"></standard-button>
            <standard-button @click="clearFilter" label="Очистить"></standard-button>
        </div>
        <smart-table
            :headers="{
                id: 'ID',
                semester_id: 'Номер семестра',
                discipline_name: 'Дисциплина',
                group_name: 'Группа',
                characteristic: 'Характеристика',
                type: 'Тип',
                hours: 'Кол-во часов'
            }"
            :items="this.loads"
            @item-click="itemClick"
        ></smart-table>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import SmartTable from "../../../Components/SmartTable";
import TextInput from "../../../Components/Inputs/TextInput";
export default {
    name: "Home",
    data: () => ({
        filter: {
            id: null,
            semester_id: null,
            discipline_id: null,
        }
    }),
    methods: {
        itemClick(event, item) {
            console.log(item);
            this.$router.push(`/manage/load/${item.id}`);
        },
        clearFilter() {
            for(const [key, value] of Object.entries(this.filter)) {
                this.filter[key] = null;
            }
            this.$store.dispatch('getLoads', this.filter);
        }
    },
    mounted() {
        if(this.is_auth) {
            this.$store.dispatch('getLoads', {});
        }
    },
    watch: {
        is_auth() {
            this.$store.dispatch('getLoads', {});
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'loads',
            'loads_disciplines'
        ])
    },
    components: {
        SmartTable,
        TextInput
    }
}
</script>

<style scoped>

</style>
