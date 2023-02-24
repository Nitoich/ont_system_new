import http from "../http";

export default {
    state: {
        loads: []
    },
    getters: {
        loads: (state) => {
            return state.loads;
        },
        loads_disciplines: (state) => {
            const disciplines = {};
            state.loads.forEach(load => {
                disciplines[load.discipline_id] = load.discipline_name
            });
            return disciplines;
        }
    },
    mutations: {
        loads: (state, value) => {
            state.loads = value;
        }
    },
    actions: {
        getLoads(context, filter) {
            context.commit('loads', []);
            http.get('/api/v1/load', {
                params: Object.assign(filter, {
                    pagination: false
                }),
                onDownloadProgress: (ProgressEvent) => {
                    console.log(ProgressEvent)
                    console.log((ProgressEvent.loaded / ProgressEvent.total) * 100);
                }
            })
                .then(response => {
                    context.commit('loads', response.data.data);
                })
        },
        async getLoad(context, id) {
            return await http.get(`/api/v1/load/${id}`)
                .then(response => {
                    return response.data.data;
                })
        },
        updateLoad(context, fields) {
            return http.patch(`/api/v1/load/${fields.id}`, fields);
        }
    }
}
