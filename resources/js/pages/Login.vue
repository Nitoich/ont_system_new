<template>
    <div class="container mx-auto">
        <div class="flex justify-center items-center flex-col">
            <text-input v-model="login" placeholder="E-MAIL"></text-input>
            <text-input v-model="password" placeholder="Пароль" :is-password="true"></text-input>
            <standard-button @click="this.click" label="Войти"></standard-button>
        </div>
    </div>
</template>

<script>
import TextInput from "../components/Inputs/TextInput";
import StandardButton from "../components/Buttons/StandardButton";
export default {
    name: "Login",
    data() {
        return {
            login: '',
            password: ''
        }
    },
    methods: {
        click() {
            alert("CLICK!");
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
