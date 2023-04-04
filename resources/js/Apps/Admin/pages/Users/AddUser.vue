<template>
    <div class="bg-white py-3">
        <h1 class="text-center text-xl">Новый пользователь</h1>
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

        <div class="fields flex flex-col items-center gap-2" v-if="user">
            <div class="field w-[369px]">
                <text-input placeholder="EMAIL" v-model="user.email"></text-input>
            </div>

            <div class="field w-[369px]">
                <text-input placeholder="Фамилия" v-model="user.last_name"></text-input>
            </div>

            <div class="field w-[369px]">
                <text-input placeholder="Имя" v-model="user.first_name"></text-input>
            </div>

            <div class="field w-[369px]">
                <text-input placeholder="Отчество" v-model="user.surname"></text-input>
            </div>

            <div class="field w-[369px]">
                <text-input placeholder="Дата рождения" v-model="user.birth_day"></text-input>
            </div>

            <div class="field w-[369px]">
                <text-input placeholder="Пароль" :is-password="true" v-model="user.password"></text-input>
            </div>

            <div class="field w-[369px]">
                <text-input placeholder="Повтор пароля" :is-password="true" v-model="user.retry_password"></text-input>
            </div>
        </div>
        <div class="text-center m-2">
            <button-group
                :buttons="{
                save: {
                    name: 'Сохранить',
                    cb: save
                },
                cancel: {
                    name: 'Отменить',
                    cb: cancel
                }
            }"
            ></button-group>
        </div>
    </div>
</template>

<script>
import TextInput from "../../../../Components/Inputs/TextInput";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup";
import {mapGetters} from "vuex";

export default {
    name: "AddUser",
    data: () => ({
        user: {
            first_name: null,
            last_name: null,
            surname: null,
            email: null,
            password: '',
            retry_password: '',
            birth_day: null
        },
        errors: null,
        success: null
    }),
    methods: {
        save() {
            this.errors = null;
            if(this.user.password !== this.user.retry_password) {
                this.errors = {
                    password: ['Пароли не совпадают!']
                };
                return false;
            }
            this.$store.dispatch('createUser', this.user)
                .then(response => {
                    if(response.status == 201) {
                        this.$router.push({ name: 'user-general', params: { id: response.data.data.id } })
                    }
                })
                .catch(error => {
                    const response = error.response;
                    if(response.status = 422) {
                        this.errors = response.data.error.errors;
                    }
                });
        },
        cancel() {}
    },
    components: {
        TextInput,
        ButtonGroup
    },
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    }
}
</script>

<style scoped>

</style>
