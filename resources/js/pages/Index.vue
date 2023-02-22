<template>
    <div class="flex justify-center items-center flex-col mt-24">
        <h1 class="text-2xl font-bold text-gray-700">Vue App</h1>
        <h1 v-if="this.is_auth" class="text-2xl font-bold text-gray-700">Авторизован</h1>
        <router-link v-if="!this.is_auth" to="/manage/login">Авторизоваться</router-link>
        <standard-button v-if="this.is_auth" @click="() => {
            $store.dispatch('logout');
        }" label="LOGOUT"></standard-button>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import StandardButton from "../components/Buttons/StandardButton";

export default {
    name: "Index",
    components: {StandardButton},
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    }
}
</script>

<style scoped>

</style>
