<template>
    <div class="aside min-w-[75px] h-screen border-r-4 border-slate-800 flex flex-col justify-between">
        <nav aria-label="Main Nav" class="flex flex-col">
            <a @click="$event.preventDefault(); $router.push(item.url)" v-for="(item, key) in this.menu_items" :class="$route.meta.page_group == key ? 'flex items-center gap-2 border-l-[3px] border-blue-500 bg-blue-50 px-4 py-3 text-blue-700 cursor-pointer' : 'flex items-center gap-2 border-l-[3px] border-transparent px-4 py-3 text-gray-500 hover:border-gray-100 hover:bg-gray-50 hover:text-gray-700 cursor-pointer'" class="">
                <span class="text-sm font-medium"> {{ item.name }} </span>
            </a>
        </nav>
        <nav v-if="this.$store.dispatch('hasRole', 'admin')">
            <standard-button @click="show_settings_popup = true" label="Настроить меню"></standard-button>
        </nav>
        <Popup v-model="show_settings_popup" :component="popup_component"></Popup>
    </div>
</template>

<script>
import http from "../../http";
import {mapGetters} from "vuex";
import Popup from "../Popup.vue";
import ASideOptions from "./ASideOptions.vue";

export default {
    name: "ASide",
    created() {
        if(this.is_auth == true) {
            this.$store.dispatch('getMenuItemAccess');
        }
    },
    data: () => ({
        // menu_items: {
        //     home: { name: 'Главная', url: '/admin/home' },
        //     users: { name: 'Пользователи', url: '/admin/users' },
        //     loads: { name: 'Нагрузка', url: '/admin/loads' },
        //     groups: { name: 'Группы', url: '/admin/groups' },
        //     discipline: { name: 'Дисциплины', url: '/admin/disciplines' },
        //     roles: { name: 'Роли', url: '/admin/roles' },
        // },
        menu_items_access: {},
        items: {},
        show_settings_popup: false,
        popup_component: ASideOptions
    }),
    computed: {
        ...mapGetters([
            'is_auth',
            'my_roles',
            'menu_items'
        ]),
    },
    components: {
        Popup
    },
    watch: {
        is_auth() {
            if(this.is_auth == true) {
                this.$store.dispatch('getMenuItemAccess');
            }
        },
        // menu_items_access() {
        //     console.log(this.is_auth)
        //
        //     if(this.is_auth) {
        //         let result = {};
        //         for(const [key, value] of Object.entries(this.menu_items)) {
        //             const role_list = this.menu_items_access[key];
        //             if(typeof role_list === 'undefined') { result[key] = value; continue; }
        //             console.log(this.my_roles)
        //             this.my_roles.forEach(role => {
        //                 console.log(role)
        //                 if(role_list.includes(role.slug)) {
        //                     result[key] = value;
        //                 }
        //             });
        //         }
        //         this.items = result;
        //     } else {
        //         this.items = {};
        //     }
        // }
    }
}
</script>

<style scoped>

</style>
