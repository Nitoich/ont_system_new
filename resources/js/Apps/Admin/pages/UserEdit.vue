<template>
    <div>
        <tabs
            :tabs="{
                'user-general': 'Основное',
                'user-roles': 'Роли'
            }"
        ></tabs>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import Tabs from "../../../Components/Tabs";

export default {
    name: "UserEdit",
    data: () => ({
        is_new: false
    }),
    mounted() {
        if(this.$route.params.id == 'new') {
            this.is_new = true;
        }

        if(this.is_auth && this.is_new) {

        }
    },
    watch: {
        is_auth() {
            if(this.is_auth && this.is_new) {

            }
        }
    },
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    },
    components: {
        Tabs
    }
}
</script>

<style scoped>

</style>
