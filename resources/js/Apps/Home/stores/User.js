import http from "../http";

export default {
    state: {
        user: undefined,
        my_roles: [],
        users: []
    },
    getters: {
        user: (state) => {
            return state.user;
        },
        my_roles: (state) => {
            return state.my_roles;
        },
        user_id: (state) => {
            return state.user.id;
        },
        users: (state) => {
            return state.users;
        }
    },
    mutations: {
        user: (state, value) => {
            state.user = value;
        },
        my_roles: (state, value) => {
            state.my_roles = value;
        },
        users: (state, value) => {
            state.users = value;
        }
    },
    actions: {
        async getMyUserData(context) {
            await http.get('/api/v1/me')
                .then(async response => {
                    context.commit('user', response.data);
                    await context.dispatch('getMyRoles');
                })
                .catch(error => {
                    console.log(error.response);
                    // console.log('error')
                })
        },
        async getMyRoles(context) {
            await http.get(`/api/v1/user/${context.getters.user_id}/role`)
                .then(response => {
                    context.commit('my_roles', response.data.data)
                })
        },
        hasRole(context, roles_slugs) {
            const roles = context.getters.my_roles;
            for(let i = 0; i < roles.length; i++) {
                if(roles_slugs.includes(roles[i].slug)) {
                    // console.log(role_slug)
                    return true;
                }
            }
            return false;
        },
        async checkRoles(context) {
            await context.dispatch('getMyUserData');
            const has = await context.dispatch('hasRole', ['admin']);
            if(!has) {
                console.log('redirect')
                window.location.href = '/';
            }
        },
        getUsers(context, params = {}) {
            return http.get('/api/v1/user', {
                params
            })
                .then(response => {
                    context.commit('users', response.data);
                })
        },
        getUser(context, id) {
            return http.get(`/api/v1/user/${id}`)
                .then(response => {
                    return response;
                });
        },
        updateUser(context, user) {
            return http.patch(`/api/v1/user/${user.id}`, user);
        },
        createUser(context, fields) {
            return http.post('/api/v1/user', fields);
        }
    }
};
