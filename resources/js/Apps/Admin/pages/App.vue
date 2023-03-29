<template>
    <div class="flex flex-row bg-slate-200 overflow-hidden max-h-screen">
        <a-side></a-side>
        <div class="container mx-auto flex-1 px-2 overflow-auto max-h-screen">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import ASide from "../components/ASide/ASide";
import Popup from "../components/Popup.vue";

export default {
    name: "application",
    components: {
        ASide,
        Popup
    }
}
</script>

<style scoped>

</style>
