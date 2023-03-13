<template>
    <div class="w-full h-full bg-white">
        <div class="flex flex-col justify-center items-center h-full">
            <text-input placeholder="E-MAIL" :error="this.errors.email" v-model="fields.email"></text-input>
            <text-input placeholder="Пароль" :error="this.errors.password" v-model="fields.password"></text-input>
            <standard-button @click="login" label="Войти"></standard-button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data: () => ({
        fields: {
            email: '',
            password: '',
            device_name: 'as'
        },
        errors: {
            email: '',
            password: ''
        }
    }),
    methods: {
        login() {
            for(const [key, errors] of Object.entries(this.errors)) {
                this.errors[key] = '';
            }
            this.$store.dispatch('login', this.fields)
                .then(response => {
                    if(typeof this.$route.query.back_url !== 'undefined') {
                        console.log(this.$route.query.back_url)
                        window.location.href = this.$route.query.back_url;
                    } else {
                        this.$router.push('/');
                    }
                })
                .catch(error => {
                    console.log(error.response);
                    const fields = error.response.data.error.errors;
                    for(const [key, errors] of Object.entries(fields)) {
                        this.errors[key] = errors[0];
                    }
                })
        }
    }

}
</script>

<style scoped>

</style>
