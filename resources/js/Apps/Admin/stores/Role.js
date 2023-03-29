import http from "../http";

export default {
    state: {
        roles: [],
    },
    getters: {
        roles: (state) => {
            return state.roles;
        }
    },
    mutations: {
        roles: (state, value) => {
            state.roles = value;
        }
    },
    actions: {
        getAllRoles({commit}) {
            return http.get('/api/v1/role')
                .then(response => {
                    console.log(response);
                    commit('roles', response.data.data);
                })
        },
        getRolesByUserId({}, id) {
            return http.get(`/api/v1/user/${id}/role`)
        },
        setRoles({}, {user_id, roles_ids}) {
            return http.post(`/api/v1/user/${user_id}/role`, {
                roles_ids
            });
        },
        getRole(context, id) {
            console.log(id)
            return http.get(`/api/v1/role/${id}`);
        }
    }

};
