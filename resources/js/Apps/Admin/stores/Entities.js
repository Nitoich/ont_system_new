import http from "../http";
import AddUser from "../pages/Users/AddUser.vue";

export default {
    state: {
        entities: {
            user: {
                name: 'Пользователь',
                primary_field: 'id',
                newFastCreateComponent: AddUser,
                name_field: 'email',
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
                name_field: 'name',
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
                name_field: 'name',
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
            group: {
                name: 'Группа',
                primary_field: 'id',
                name_field: 'name',
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
                }
            },
            discipline: {
                name: 'Дисциплина',
                primary_field: 'id',
                name_field: 'name',
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
                    speciality_id: {
                        name: 'Специальность',
                        type: 'string',
                        hidden: true
                    },
                    speciality_name: {
                        name: 'Специальность',
                        type: 'entity:speciality',
                        reference_field: 'speciality_id'
                    }
                },
            },
            load: {
                name: 'Нагрузка',
                primary_field: 'id',
                fields: {
                    id: {
                        name: 'ID',
                        type: 'string',
                        writable: false
                    },
                    user_id: {
                        name: 'user_id',
                        type: 'string',
                        hidden: true
                    },
                    user_full_name: {
                        name: 'Пользователь',
                        type: 'entity:user',
                        reference_field: 'user_id'
                    },
                    discipline_id: {
                        name: 'discipline_id',
                        type: 'string',
                        hidden: true
                    },
                    discipline_name: {
                        name: 'Дисциплина',
                        type: 'entity:discipline',
                        reference_field: 'discipline_id'
                    },
                    group_id: {
                        name: 'group_id',
                        type: 'string',
                        hidden: true
                    },
                    group_name: {
                        name: 'Группа',
                        type: 'entity:group',
                        reference_field: 'group_id'
                    },
                    characteristic: {
                        name: 'Хар-ка',
                        type: 'select',
                        items: {
                            commerce: 'Коммерция',
                            budget: 'Бюджет'
                        }
                    },
                    type: {
                        name: 'Тип',
                        type: 'select',
                        items: {
                            load: 'Нагрузка',
                            vacancy: 'Вакансия'
                        }
                    },
                    hours: {
                        name: 'Кол-во часов',
                        type: 'string'
                    }
                }
            }
        }
    },
    getters: {
        entities: (state) => { return state.entities; }
    },
    actions: {
        getReferencesFields(context, entity_name) {
            const entity = context.getters.entities[entity_name];
            const entity_fields = entity.fields;
            return Object.keys(entity_fields)
                .filter(key => entity_fields[key].type.includes('entity:'))
                .reduce((response, key) => (response[key] = entity_fields[key], response), {})
        },
        validateEntity(context, entity_name) {
            const entity = context.getters.entities[entity_name];
            const validateProperty = (name, ctx = entity) => {
                let message = '';
                if(typeof ctx[name] === 'undefined') {
                    message = `Not found property "${name}" in ${entity_name} entity!`
                    window.notify({
                        type: 'error',
                        content: message
                    });
                    throw message;
                }
                if(typeof ctx[name] === 'object' && Object.keys(ctx[name]).length === 0) {
                    message = `Property "${name}" must not be empty!"`;
                    window.notify({
                        type: 'error',
                        content: message
                    });
                    throw message;
                }
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
            return http.get(`/api/v1/${payload.entity}/${payload.primary_field}`);
        }
    }
};
