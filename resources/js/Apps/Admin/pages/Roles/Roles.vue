<template>
    <div>
        <div>
            <standard-button @click="createRole" label="Создать"></standard-button>
        </div>
        <SmartTable
            :headers="{
                id: 'ID',
                name: 'Название',
                slug: 'Код'
            }"
            :items="this.roles"
            :link-columns="{
                id: (item) => `/admin/role/${item.id}`,
                name: (item) => `/admin/role/${item.id}`,
                slug: (item) => `/admin/role/${item.id}`,
            }"
        ></SmartTable>
        <Popup v-model="show_create_new_role_popup" :component="this.CreateRole"></Popup>
    </div>
</template>

<script>
import SmartTable from "../../../../Components/SmartTable.vue";
import {mapGetters} from "vuex";
import Popup from "../../components/Popup.vue";
import CreateRole from "./CreateRole.vue";

export default {
    name: "Roles",
    data: () => ({
        show_create_new_role_popup: false,
    }),
    mounted() {
        if(this.is_auth) {
            this.$store.dispatch('getAllRoles');
        }
    },
    methods: {
        createRole(event) {
            this.show_create_new_role_popup = true;
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'roles'
        ]),
        CreateRole() {
            return CreateRole;
        }
    },
    components: {
        Popup,
        SmartTable
    }
}
</script>

<style scoped>

</style>
