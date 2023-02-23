<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "application",
    async mounted() {
        await this.$store.dispatch('refresh')
            .then(async response => {
                this.$store.dispatch('checkRoles');
            })
            .catch((error) => {
                this.$router.replace('/manage/login')
            }) ;
    }
}
</script>

<style scoped>

</style>
