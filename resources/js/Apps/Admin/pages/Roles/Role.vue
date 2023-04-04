<template>
    <div class="p-3 bg-white">
        <div v-if="errors" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ошибка валидации:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    <li v-for="error in errors">{{ error[0] }}</li>
                </ul>
            </div>
        </div>

        <div class="fields flex flex-col items-center gap-2" v-if="fields">
            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">ID:</span>
                <span>{{ fields.id }}</span>
            </div>

            <div class="w-[370px]">
                <TextInput v-model="fields.name" placeholder="Название"></TextInput>
            </div>

            <div class="w-[370px]">
                <TextInput v-model="fields.slug" placeholder="Код"></TextInput>
            </div>
        </div>
        <div class="text-center mt-2">
            <ButtonGroup
                :buttons="[
                    {
                        name: 'Сохранить',
                        cb: save
                    },
                    {
                        name: 'Применить',
                        cb: accept
                    },
                    {
                        name: 'Отменить',
                        cb: () => {}
                    },
                    {
                        name: 'Удалить',
                        cb: () => {}
                    }
                ]"
            ></ButtonGroup>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import TextInput from "../../../../Components/Inputs/TextInput.vue";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
import http from "../../http";

export default {
    name: "Role",
    data: () => ({
        fields: undefined,
        errors: null
    }),
    created() {
        // console.log(this.$route)
        if(this.is_auth) {
            this.$store.dispatch('getRole', this.$route.params.id)
                .then(({ data }) => {
                    this.fields =  data.data;
                })
        }
    },
    methods: {
        save() {

        },
        accept() {
            http.patch(`/api/v1/role/${this.$route.params.id}`, this.fields)
                .then(response => {
                    console.log(response)
                    window.notify({
                        type: 'success',
                        content: `Роль ${this.fields.slug} успешно обновлена!`
                    });
                })
                .catch(({ response }) => {
                    if(response.status == 422) {
                        this.$set(this, 'errors', response.data.error.errors);
                    }
                })
        }
    },
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    },
    components: {
        TextInput,
        ButtonGroup
    }
}
</script>

<style scoped>

</style>
