import http from "../http";

export default {
    state: {
        groups: []
    },
    getters: {
        groups_for_select: (state) => {
            const groups = {};
            state.groups.map(group => {
                groups[group.id] = group.name;
            });
            return groups;
        }
    },
    mutations: {
        groups: (state, value) => {
            state.groups = value;
        }
    },
    actions: {
        getGroups(context, config) {
            return http.get('/api/v1/group', config)
                .then(response => {
                    context.commit('groups', response.data.data);
                    return response;
                })
        }
    }
}
