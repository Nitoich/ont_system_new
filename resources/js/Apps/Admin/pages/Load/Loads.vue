<template>
    <div>
        <div class="flex">
            <v-filter class="flex-1"
                :fields="filter"
                v-model="filterValues"
            ></v-filter>
            <standard-button label="Новая запись" @click="show_popup = true"></standard-button>
        </div>

        <smart-table
            v-if="loads"
            :headers="{
                id: 'ID',
                user_full_name: 'Пользователь',
                discipline_name: 'Дисциплина',
                group_name: 'Группа',
                type: 'Тип',
                characteristic: 'Характиристика',
                hours: 'Кол-во часов'
            }"
            :link-columns="{
                user_full_name: (item) => { return `/admin/user/${item.user_id}` },
                discipline_name: (item) => { return `/admin/user/${item.user_id}` },
                group_name: (item) => { return `/admin/user/${item.user_id}` },
            }"
            :items="loads"
        ></smart-table>
        <default-pagination
            :pagination-meta="this.loads.meta"
            @click="paginationClick"
        ></default-pagination>
        <Popup v-model="show_popup" :component="popupComponent"></Popup>
    </div>
</template>

<script>
import SmartTable from "../../../../Components/SmartTable";
import DefaultPagination from "../../../../Components/Pagination/DefaultPagination";
import Filter from "../../../../Components/Filter";
import http from "../../http";
import {mapGetters} from "vuex";
import Popup from "../../components/Popup.vue";
import NewLoad from "./NewLoad.vue";

export default {
    name: "Loads",
    data: () => ({
        popupComponent: NewLoad,
        show_popup: false,
        filterValues: undefined,
        filter: {
            id: {
                name: 'ID'
            },
            user_id: {
                name: 'ID пользователя'
            },
            type: {
                name: 'Тип',
                type: 'select',
                items: {
                    vacancy: 'Вакансия',
                    load: 'Нагрузка'
                }
            }
        }
    }),
    mounted() {
        if(this.is_auth) {
            this.$store.dispatch('getLoads', {})
        }
    },
    methods: {
        paginationClick(event, link) {
            http.get(link.url, {
                params: this.filterValues
            })
                .then((response) => {
                    this.$store.commit('loads', response.data)
                });
        }
    },
    watch: {
        is_auth() {
            if(this.is_auth) {
                this.$store.dispatch('getLoads', {})
            }
        },
        filterValues() {
            this.$store.dispatch('getLoads', this.filterValues)
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'loads',
            'loads_pagination'
        ])
    },
    components: {
        SmartTable,
        DefaultPagination,
        'v-filter': Filter,
        Popup
    }
}
</script>

<style scoped>

</style>
