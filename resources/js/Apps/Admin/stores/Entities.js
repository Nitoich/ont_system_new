import http from "../http";

export default {
    state: {
        entities: {
            speciality: {
                name: 'Специальность',
                primary_field: 'id',
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
            }
        }
    },
    getters: {
        entities: (state) => { return state.entities; }
    },
    actions: {
        validateEntity(context, entity_name) {
            const entity = context.getters.entities[entity_name];
            const validateProperty = (name, ctx = entity) => {
                if(typeof ctx.name === 'undefined') { throw `Not found property "${name}" in ${entity_name} entity!`}
            };

            validateProperty('name');
            validateProperty('primary_field');
            validateProperty('fields');
        },
        getEntityItems(context, payload) {
            let requestLink = '';

            if(!payload.link) {
                requestLink = `/api/v1/${payload.entity}`;
            } else { requestLink = payload.link; }

            return http.get(requestLink, {
                params: payload.filter
            });
        },
        createEntityItem(context, payload) {
            return http.post(`/api/v1/${payload.entity}`, payload.data);
        },
        getEntityItem(context, payload) {
            return http.get(`/api/v1/${payload.entity}/${payload.id}`);
        }
    }
};
