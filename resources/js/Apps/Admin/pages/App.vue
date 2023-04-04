<template>
    <div>
        <NotificationBar content-classes="flex flex-row bg-slate-200 overflow-hidden max-h-screen">
            <a-side></a-side>
            <div class="container mx-auto flex-1 px-2 overflow-auto max-h-screen">
                <router-view></router-view>
            </div>
        </NotificationBar>
    </div>
</template>

<script>
import ASide from "../components/ASide/ASide";
import Popup from "../components/Popup.vue";
import NotificationBar from "../components/NotificationBar.vue";

export default {
    name: "application",
    components: {
        NotificationBar,
        ASide,
        Popup
    }
}
</script>

<style scoped>

</style>
