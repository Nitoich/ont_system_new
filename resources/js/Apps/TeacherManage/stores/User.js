import http from "../http";
import {value} from "lodash/seq";

export default {
    state: {
        user: undefined,
        roles: undefined
    },
    getters: {
        user: (state) => {
            return state.user;
        },
        roles: (state) => {
            return state.roles;
        },
        user_id: (state) => {
            return state.user.id;
        }
    },
    mutations: {
        user: (state, value) => {
            state.user = value;
        },
        roles: (state, value) => {
            state.roles = value;
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
                    context.commit('roles', response.data)
                })
        },
        hasRole(context, roles_slugs) {
            const roles = context.getters.roles;
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
            const has = await context.dispatch('hasRole', ['teacher', 'admin']);
            if(!has) {
                console.log('redirect')
                window.location.href = '/';
            }
        }
    }
};
