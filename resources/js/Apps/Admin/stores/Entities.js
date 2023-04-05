import http from "../http";
import AddUser from "../pages/Users/AddUser.vue";

export default {
    state: {
        entities: {
            user: {
                name: 'Пользователь',
                primary_field: 'id',
                newFastCreateComponent: AddUser,
                fields: {
                    id: {
                        name: 'ID',
                        type: 'string',
                        writable: false
                    },
                    email: {
                        name: 'EMAIL',
                        type: 'string'
                    },
                    last_name: {
                        name: 'Фамилия',
                        type: 'string'
                    },
                    first_name: {
                        name: 'Имя',
                        type: 'string'
                    },
                    surname: {
                        name: 'Отчество',
                        type: 'string'
                    },
                    password: {
                        name: 'Пароль',
                        type: 'string',
                        hidden: true
                    },
                }
            },
            role: {
                name: 'Роль',
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
                    }
                }
            },
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
                if(typeof ctx[name] === 'undefined') { throw `Not found property "${name}" in ${entity_name} entity!`; }
                if(typeof ctx[name] === 'object' && Object.keys(ctx[name]).length === 0) { throw `Property "${name}" must not be empty!"`; }
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
