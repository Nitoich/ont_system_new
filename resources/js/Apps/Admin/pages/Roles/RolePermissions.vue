<template>
    <div class="">
        <div class="grid grid-cols-5">
            <SelectorItems v-model="selected_have" :multiple="true" class="col-span-2" :items="have_permissions"></SelectorItems>
            <div class="controlls flex flex-col items-center justify-center gap-[40px] px-[30px]">
                <standard-button @click="disablePermissions" class="w-full" label="->"></standard-button>
                <standard-button @click="enablePermissions" class="w-full" label="<-"></standard-button>
            </div>
            <SelectorItems v-model="selected_other" :multiple="true" class="col-span-2 min-h-[408px]" :items="other_permissions()"></SelectorItems>
        </div>
        <div class="p-2 flex justify-center">
            <ButtonGroup
                :buttons="[
                    {
                        name: 'Сохранить',
                        cb: save
                    },
                    {
                        name: 'Применить',
                        cb: accept
                    },
                    {
                        name: 'Отменить',
                        cb: cancel
                    }
                ]"
            ></ButtonGroup>
        </div>
    </div>
</template>

<script>
import SelectorItems from "../../../../Components/SelectorItems.vue";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
import {mapGetters} from "vuex";
import http from "../../http";
export default {
    name: "RolePermissions",
    data: () => ({
        have_permissions: {},
        selected_have: [],
        selected_other: [],
    }),
    mounted() {
        if(this.is_auth) {
            this.getPermissions();
            this.$store.dispatch('getPermissions');
        }
    },
    methods: {
        save() {
            this.accept();
            this.cancel();
        },
        cancel() {
            this.$router.push('/admin/roles');
        },
        accept() {
            http.patch(`/api/v1/role/${this.$route.params.id}`, {
                permissions: Object.keys(this.have_permissions)
            })
                .then(response => {
                    console.log(response)
                })
        },
        getPermissions() {
            http.get(`/api/v1/role/${this.$route.params.id}/permission`)
                .then(response => {
                    response.data.data.forEach((permission) => {
                        this.$set(this.have_permissions, permission.id, permission.name);
                    });
                })
        },
        other_permissions() {
            if(typeof this.have_permissions === 'undefined') {
                return {};
            }
            const result = {};
            for(const [key, value] of Object.entries(this.permissions_selector)) {
                if(!this.have_permissions.hasOwnProperty(key)) {
                    result[key] = value;
                }
            }
            return result;
        },
        disablePermissions(event) {
            this.selected_have.forEach(permission => {
                delete(this.have_permissions[permission]);
                this.$set(this, 'have_permissions', this.have_permissions);
            });
            this.$set(this, 'selected_have', []);
        },
        enablePermissions(event) {
            this.selected_other.forEach(permission => {
                this.$set(this.have_permissions, permission, this.other_permissions()[permission]);
            });
            this.$set(this, 'selected_other', []);
        }
    },
    components: {
        SelectorItems,
        ButtonGroup
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'permissions_selector'
        ]),
        // other_permissions() {
        //     if(typeof this.have_permissions === 'undefined') {
        //         return {};
        //     }
        //     const result = {};
        //     for(const [key, value] of Object.entries(this.permissions_selector)) {
        //         if(!this.have_permissions.hasOwnProperty(key)) {
        //             result[key] = value;
        //         }
        //     }
        //     return result;
        // }
    }
}
</script>

<style scoped>

</style>
