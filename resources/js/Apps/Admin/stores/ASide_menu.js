import http from "../http";
import store from "../Store";

export default {
    state: {
        menu_items: {
            home: { name: 'Главная', url: '/admin/home' },
            users: { name: 'Пользователи', url: '/admin/users' },
            loads: { name: 'Нагрузка', url: '/admin/loads' },
            groups: { name: 'Группы', url: '/admin/groups' },
            discipline: { name: 'Дисциплины', url: '/admin/disciplines' },
            roles: { name: 'Роли', url: '/admin/roles' },
        },
        menu_items_access: {},
    },
    getters: {
        menu_items: (state) => {
            let result = {};
            for(const [key, value] of Object.entries(state.menu_items)) {
                const role_list = state.menu_items_access[key];
                if(typeof role_list === 'undefined') { result[key] = value; continue; }
                store.getters.my_roles.forEach(role => {
                    if(role_list.includes(role.slug)) {
                        result[key] = value;
                    }
                });
            }
            return result;
        },
        all_menu_items: (state) => {
            return state.menu_items;
        },
        menu_items_access: (state) => {
            return state.menu_items_access;
        }
    },
    mutations: {
        menu_items_access: (state, value) => {
            state.menu_items_access = value;
        }
    },
    actions: {
        getMenuItemAccess: (context, payload) => {
            http.get('/api/v1/data-storage/admin_left_menu_accesses')
                .then(response => {
                    // this.$set(this, 'menu_items_access', response.data.data);
                    context.commit('menu_items_access', response.data.data);
                })
        },
        setMenuItemAccess: (context, payload) => {
            return http.put('/api/v1/data-storage/admin_left_menu_accesses', {
                ...payload
            })
        }
    }
}
