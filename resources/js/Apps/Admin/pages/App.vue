<template>
    <div class="flex flex-row bg-slate-200">
        <a-side></a-side>
        <div class="container mx-auto flex-1 px-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import ASide from "../components/ASide/ASide";

export default {
    name: "application",
    components: {
        ASide
    },
    created() {
        this.$store.dispatch('refresh')
            .then(response => {
                this.$store.dispatch('checkRoles');
            })
            .catch((error) => {
                this.$router.replace('/admin/login')
            }) ;
    }
}
</script>

<style scoped>

</style>
