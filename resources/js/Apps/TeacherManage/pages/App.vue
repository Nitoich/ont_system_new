<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "application",
    async mounted() {
        this.$store.dispatch('refresh').catch((error) => {
            this.$router.push('/manage/login')
        }) ;
    }
}
</script>

<style scoped>

</style>
