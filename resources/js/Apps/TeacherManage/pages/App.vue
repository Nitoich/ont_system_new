<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "application",
    created() {
        this.$store.dispatch('refresh')
            .then(response => {
                this.$store.dispatch('checkRoles');
            })
    }
}
</script>

<style scoped>

</style>
