<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "application",
    mounted() {
        this.$store.dispatch('refresh');
    }
}
</script>

<style scoped>

</style>
