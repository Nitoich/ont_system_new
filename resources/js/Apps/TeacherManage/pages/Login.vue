<template>
    <div class="container mx-auto">
        <div class="flex justify-center items-center flex-col">
            <text-input v-model="email" :error="this.errors.email" placeholder="E-MAIL"></text-input>
            <text-input v-model="password" :error="this.errors.password" placeholder="Пароль" :is-password="true"></text-input>
            <standard-button @click="this.click" label="Войти"></standard-button>
        </div>
    </div>
</template>

<script>
import TextInput from "../../../Components/Inputs/TextInput";
import StandardButton from "../../../Components/Buttons/StandardButton";
import {mapGetters} from "vuex";
export default {
    name: "Login",
    data() {
        return {
            email: '',
            password: '',
            errors: {
                email: '',
                password: ''
            }
        }
    },
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    },
    mounted() {
        this.checkAuth();
    },
    watch: {
        is_auth: function() {
            this.checkAuth();
        }
    },
    methods: {
        checkAuth() {
            if(this.is_auth) {
                this.$router.push('/manage/home');
            }
        },
        click() {
            for(const [key, errors] of Object.entries(this.errors)) {
                this.errors[key] = '';
            }
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password,
                device_name: 'WEB'
            })
                .then(response => {
                    this.$router.push('/manage/home');
                })
                .catch(error => {
                    console.log(error.response)
                    const fields = error.response.data.error.errors;
                    for(const [key, errors] of Object.entries(fields)) {
                        this.errors[key] = errors[0];
                    }
                })
        }
    },
    components: {
        TextInput,
        StandardButton
    }
}
</script>

<style scoped>

</style>
