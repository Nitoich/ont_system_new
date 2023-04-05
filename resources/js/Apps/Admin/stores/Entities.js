import http from "../http";

export default {
    state: {
        entities: {
            speciality: {
                name: 'Специальность',
                fields: {
                    id: {
                        name: 'ID',
                        type: 'string',
                        writable: false
                    },
                    name: {
                        name: 'Название',
                        type: 'string'
                    },
                    slug: {
                        name: 'Код',
                        type: 'string'
                    },
                },
            },
            discipline: {
                fields: {
                    id: {
                        name: 'ID',
                        type: 'string'
                    },
                    name: {
                        name: 'Название',
                        type: 'string'
                    },
                    slug: {
                        name: 'Код',
                        type: 'string'
                    },
                    speciality_id: {
                        name: 'Специальность',
                        type: 'entity:speciality'
                    }
                },
                pages: ['all', 'solo']
            }
        }
    },
    getters: {
        entities: (state) => { return state.entities; }
    },
    actions: {
        getEntityItems(context, payload) {
            let requestLink = '';
            if(!payload.link) {
                requestLink = `/api/v1/${payload.entity}`;
            } else { requestLink = payload.link }
            return http.get(requestLink, {
                params: payload.filter
            });
        }
    }
};
