<template>
    <div class="bg-white p-2">
        <div class="title">
            <h1 class="text-2xl text-center">{{ entity_config.name }}</h1>
        </div>

        <div v-if="entity_fields_values" class="fields flex flex-col gap-2 items-center">
            <div v-if="field.hidden != true" v-for="(field, key) in prepared_entity_fields" class="w-[369px]">
                <template v-if="typeof field.writable === 'undefined' || field.writable == true">
                    <TextInput
                        v-if="field.type == 'string'"
                        v-model="entity_fields_values[key]"
                        :placeholder="field.name"
                    ></TextInput>
                    <EntitySelector
                        v-if="field.type.includes('entity:')"
                        v-model="entity_fields_values[key]"
                        :entity="field.type.replace('entity:', '')"
                        :placeholder="field.name"
                    ></EntitySelector>
                    <SmartSelect
                        v-if="field.type == 'select'"
                        v-model="entity_fields_values[key]"
                        :items="field.items"
                        :placeholder="field.name"
                    ></SmartSelect>
                </template>
                <template v-else>
                    <div class="field grid grid-cols-2 items-center justify-center">
                        <span class="text-right">{{ field.name }}:</span>
                        <span>{{ entity_fields_values[key] }}</span>
                    </div>
                </template>
            </div>
        </div>

        <div class="btns text-center py-2">
            <ButtonGroup
                :buttons="{
                    save: {
                        name: 'Сохранить',
                        cb: save
                    },
                    accept: {
                        name: 'Принять',
                        cb: accept
                    },
                    cancel: {
                        name: 'Отменить',
                        cb: cancel
                    },
                    delete: {
                        name: 'Удалить',
                        cb: remove
                    }
                }"
            ></ButtonGroup>
        </div>

    </div>
</template>

<script>
import TextInput from "../../../../Components/Inputs/TextInput.vue";
import {mapGetters} from "vuex";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
import EntitySelector from "../../components/EntitiesComponents/EntitySelector.vue";
import SmartSelect from "../../components/Inputs/SmartSelect.vue";

export default {
    name: "SingleEntity",
    data: () => ({
        entity_config: null,
        entity_fields: null,
        entity_fields_values: null
    }),
    created() {
        this.entity_config = this.entities[this.entity];
        this.entity_fields = this.entity_config.fields;
        this.$store.dispatch('getEntityItem', {
            entity: this.entity,
            primary_field: this.$route.params.id
        })
            .then((response) => {
                this.entity_fields_values = {};
                this.$set(this, 'entity_fields_values', response.data.data);
            })
            .catch(({ response }) => {
                console.log(response);
            })
    },
    methods: {
        save() {
            this.accept().then(() => {
                this.cancel();
            });
        },
        accept() {
            return this.$store.dispatch('updateEntityItem', {
                entity: this.entity,
                data: this.entity_fields_values
            })
                .then(response => {
                    console.log(response);
                    window.notify({
                        type: 'success',
                        content: 'Обновлено!'
                    });
                })
                .catch(({ response }) => {
                    console.log(response.data);
                });
        },
        cancel() {
            this.$router.back();
        },
        remove() {}
    },
    props: {
        entity: {
            type: String
        }
    },
    components: {
        SmartSelect,
        EntitySelector,
        TextInput,
        ButtonGroup
    },
    computed: {
        ...mapGetters([
            'entities'
        ]),
        prepared_entity_fields() {
            const result = {};
            for(const [key, field] of Object.entries(this.entities[this.entity].fields)) {

                if(field.hidden == true) {
                    continue;
                }

                if(field.type.includes('entity:')) {
                    result[field.reference_field] = field;
                    continue;
                }

                result[key] = field
            }
            console.log(result)
            return result;
        },
    }
}
</script>

<style scoped>

</style>
