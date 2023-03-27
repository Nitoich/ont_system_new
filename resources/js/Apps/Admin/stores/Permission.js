import http from "../http";

export default {
    state: {
        permissions: []
    },
    getters: {
        permissions: (state) => {
            return state.permissions;
        }
    },
    mutations: {
        permissions: (state, value) => {
            state.permissions = value;
        }
    },
    actions: {
        getPermissions: async (context, payload) => {
            return await http.get()
                .then(response => response.data);
        },
    }
};
