<template>
    <div>
        <div v-if="this.errors" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Произошла ошибка валидации:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    <li v-for="(error, key) in this.errors">{{ error[0] }}</li>
                </ul>
            </div>
        </div>

        <div v-if="success" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Успешно!</span> {{ success.message }}
        </div>

        <div class="fields items-center flex flex-col gap-2 py-2 " v-if="user">
            <div class="field grid grid-cols-2 items-center justify-center">
                <span class="text-right">ID:</span>
                <span>{{ user.id }}</span>
            </div>

            <div class="w-[369px]">
                <text-input placeholder="EMAIL" v-model="user.email"></text-input>
            </div>

            <div class="w-[369px]">
                <text-input placeholder="Фамилия" v-model="user.last_name"></text-input>
            </div>

            <div class="w-[369px]">
                <text-input placeholder="Имя" v-model="user.first_name"></text-input>
            </div>

            <div class="w-[369px]">
                <text-input placeholder="Отчество" v-model="user.surname"></text-input>
            </div>

            <div class="w-[369px]">
                <text-input placeholder="Дата рождения" v-model="user.birth_day"></text-input>
            </div>

            <button-group ref="btns"
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
                    cb: this.delete
                }
            }"
            ></button-group>
        </div>
        <div class="text-center">

        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import TextInput from "../../../../../Components/Inputs/TextInput";
import ButtonGroup from "../../../../../Components/Buttons/ButtonGroup";

export default {
    name: "General",
    data: () => ({
        user: null,
        errors: null,
        success: null
    }),
    mounted() {
        if(this.is_auth) {
            this.getUser();
        }
    },
    methods: {
        delete() {

        },
        async save() {
            const response = await this.accept();
            if(response) {
                this.$router.push('/admin/users');
            }
        },
        accept() {
            this.success = null;
            this.errors = null;
            return this.$store.dispatch('updateUser', this.user)
                .then(response => {
                    if(response.status == 200) {
                        this.success = {
                            message: 'Данные обновлены!'
                        };

                        return response;
                    }
                    throw response;
                })
                .catch(error => {
                    const response = error.response;
                    if(response.status == 422) {
                        this.errors = response.data.error.errors;
                    }
                });
        },
        cancel() {
            this.$router.push('/admin/users')
        },
        getUser() {
            this.$store.dispatch('getUser', this.$route.params.id)
                .then(response => {
                    this.user = response.data.data;
                });
        }
    },
    watch: {
        is_auth() {
            if(this.is_auth) {
                this.getUser();
            }
        }
    },
    components: {
        TextInput,
        ButtonGroup
    },
    computed: {
        ...mapGetters([
            'is_auth'
        ]),
    }
}
</script>

<style scoped>

</style>
