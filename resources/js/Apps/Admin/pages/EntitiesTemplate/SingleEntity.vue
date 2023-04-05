<template>
    <div class="bg-white p-2">
        <div class="title">
            <h1 class="text-2xl text-center">{{ entity_config.name }}</h1>
        </div>

        <div v-if="entity_fields_values" class="fields flex flex-col gap-2 items-center">
            <div v-for="(field, key) in entity_fields" class="w-[369px]">
                <template v-if="typeof field.writable === 'undefined' || field.writable == true">
                    <TextInput
                        v-model="entity_fields_values[key]"
                        :placeholder="field.name"
                    ></TextInput>
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
                        cb: () => {}
                    },
                    accept: {
                        name: 'Принять',
                        cb: () => {}
                    },
                    cancel: {
                        name: 'Отменить',
                        cb: () => {}
                    },
                    delete: {
                        name: 'Удалить',
                        cb: () => {}
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
    props: {
        entity: {
            type: String
        }
    },
    components: {
        TextInput,
        ButtonGroup
    },
    computed: {
        ...mapGetters([
            'entities'
        ])
    }
}
</script>

<style scoped>

</style>
