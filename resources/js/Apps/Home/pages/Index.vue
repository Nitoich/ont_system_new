<template>
    <div class="flex justify-center items-center flex-col text-white">
        <img src="/images/home/logo.png" alt="logo" class="w-[100px] h-[100px]">
        <h1 class="text-2xl text-center">Добро пожаловать в электронный дневник Орского нефтяного техникума</h1>
        <p class="text-center">Логин и пароль выдается классным руководителем только родителям обучающегося</p>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: "Index",
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    }
}
</script>

<style scoped>

</style>
