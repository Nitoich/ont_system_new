<template>
    <div>
        <Tabs
            :tabs="{
                'role-general': 'Основное',
                'role-permissions': 'Права'
            }"
        ></Tabs>
    </div>
</template>

<script>
import Tabs from "../../../../Components/Tabs.vue";
export default {
    name: "RoleEdit",
    components: {
        Tabs
    }
}
</script>

<style scoped>

</style>
