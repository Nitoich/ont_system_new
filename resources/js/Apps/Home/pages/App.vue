<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "application",
    mounted() {
        this.$store.dispatch('refresh').catch(err => {
            console.log(err)
        });
    }
}
</script>

<style scoped>

</style>
