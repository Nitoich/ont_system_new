import http from "../http";
import permissions from "../pages/Users/UserEdit/Permissions.vue";

export default {
    state: {
        permissions: []
    },
    getters: {
        permissions: (state) => {
            return state.permissions;
        },
        permissions_selector: (state) => {
            const result = {};
            state.permissions.forEach(permission => {
                result[permission.id] = permission.name;
            });
            return result;
        },
    },
    mutations: {
        permissions: (state, value) => {
            state.permissions = value;
        }
    },
    actions: {
        getPermissions: async (context, payload) => {
            return await http.get('/api/v1/permission')
                .then(response => {
                    context.commit('permissions', response.data.data);
                });
        },
    }
};
