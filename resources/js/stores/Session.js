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
        refresh: (context) => {
            axios.get('/api/v1/session/refresh', {
                withCredentials: true
            })
                .then(response => {
                    const token = response.data.data.access_token;
                    context.commit('access_token', token);
                    context.state.is_auth = true;
                })
                .catch(error => {
                    router.push('/manage/login');
                })
        },
        login: async (context, data) => {
            return await axios.post('/api/v1/login', data, {
                withCredentials: true
            });
        },
        logout: async (context) => {
            return await axios.get('/api/v1/logout', {
                withCredentials: true
            }).then(response => {
                context.commit('is_auth', false);
            });
        }
    }
};
