import http from "../http";

export default {
    state: {
        loads: undefined
    },
    getters: {
        loads: (state) => {
            if(typeof state.loads !== 'undefined') {
                return state.loads.data;
            }
            return [];
        },
        loads_pagination: (state) => {
            return state.loads.meta;
        }
    },
    mutations: {
        loads: (state, value) => {
            state.loads = value;
        }
    },
    actions: {
        getLoads: (context, params) => {
            http.get('/api/v1/load', {
                params
            })
                .then(response => {
                    context.commit('loads', response.data);
                })
        },
    }
};
