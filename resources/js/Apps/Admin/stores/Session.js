import axios from "axios";
import router from "../router/router";

export default {
    state: {
        access_token: undefined,
        is_auth: false
    },
    getters: {
        access_token: (state) => {
            return state.access_token;
        },
        is_auth: (state) => {
            return state.is_auth;
        }
    },
    mutations: {
        access_token: (state, value) => {
            state.access_token = value;
        },
        is_auth: (state, value) => {
            state.is_auth = value;
        }
    },
    actions: {
        refresh: async (context) => {
            return await axios.get('/api/v1/session/refresh', {
                withCredentials: true
            })
                .then(response => {
                    const token = response.data.data.access_token;
                    context.commit('access_token', token);
                    context.state.is_auth = true;
                    return response;
                })
                .catch(error => {
                    const response = error.response;
                    if(response.status == 403 || response.status == 404) {
                        window.location.href = `/login?back_url=${router.history.current.path}`;
                    }
                });

        },
        login: async (context, data) => {
            return await axios.post('/api/v1/login', data, {
                withCredentials: true
            })
                .then(response => {
                    context.commit('access_token', response.data.data.access_token);
                    context.commit('is_auth', true);
                    context.dispatch('getMyUserData');
                    context.dispatch('checkRoles');
                    return response;
                });
        },
        logout: async (context) => {
            return await axios.get('/api/v1/logout', {
                withCredentials: true
            }).then(response => {
                context.commit('is_auth', false);
                return response;
            });
        },
    }
};
