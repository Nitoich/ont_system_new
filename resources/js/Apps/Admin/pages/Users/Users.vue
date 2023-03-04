<template>
    <div>
        <div class="header flex items-center">
            <v-filter class="flex-1" :fields="filter" v-model="filterValues"></v-filter>
            <div class="btns">
                <standard-button @click="$router.push('/admin/user/new')" label="Создать пользователя"></standard-button>
            </div>
        </div>
        <smart-table
            class="min-h-[408px]"
            :headers="{
                id: 'ID',
                email: 'EMAIL',
                last_name: 'Фамилия',
                first_name: 'Имя',
                surname: 'Отчество',
                birth_day: 'Дата Рождения',
                created_at: 'Дата регистрации'
            }"
            :items="this.users.data"
            @item-click="itemClick"
        ></smart-table>
        <default-pagination @click="paginationClick" class="py-2"
            :pagination-meta="this.users.meta"
        ></default-pagination>
    </div>
</template>

<script>
import SmartTable from "../../../../Components/SmartTable";
import {mapGetters} from "vuex";
import Filter from "../../../../Components/Filter";
import DefaultPagination from "../../../../Components/Pagination/DefaultPagination";
import http from "../../http";

export default {
    name: "Users",
    data: () => ({
        filter: {
            id: {
                name: 'ID',
                type: 'text'
            },
            email: {
                name: 'EMAIL',
            },
            role_id: {
                name: 'Роль',
                type: 'select',
                items: {
                    1: 'Админ',
                    2: 'Пользователь'
                }
            },
            last_name: {
                name: 'Фамилия'
            },
            first_name: {
                name: 'Имя'
            },
            surname: {
                name: 'Отчество'
            },
            // birth_day: {
            //     name: 'Дата рождения',
            //     type: 'date'
            // },
            // created_at: {
            //     name: 'Дата регистрации',
            //     type: ''
            // }
        },
        filterValues: undefined
    }),
    components: {
        SmartTable,
        'v-filter': Filter,
        DefaultPagination
    },
    methods: {
        itemClick(event, item) {
            this.$router.push(`/admin/user/${item.id}`);
        },
        paginationClick(event, link) {
            http.get(link.url)
                .then(response => {
                    this.$store.commit('users', response.data)
                })
        }
    },
    mounted() {
        if(this.is_auth) {
            this.$store.dispatch('getUsers');
        }
    },
    watch: {
        is_auth() {
            this.$store.dispatch('getUsers');
        },
        filterValues() {
            this.$store.dispatch('getUsers', this.filterValues);
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'users'
        ])
    }

}
</script>

<style scoped>

</style>
