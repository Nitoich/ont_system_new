<template>
    <div class="flex justify-center items-center">
        <div class="roles">
            <div v-for="role in this.roles" class="role">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input :data-id="role.id" ref="roles" type="checkbox" class="sr-only peer" :checked="typeof user_roles_formated[role.slug] !== 'undefined'">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ role.name }}</span>
                </label>
            </div>
            <button-group
                :buttons="{
                    save: {
                        name: 'Сохранить',
                        cb: save
                    },
                }"
            ></button-group>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ButtonGroup from "../../../../../Components/Buttons/ButtonGroup";

export default {
    name: "Roles",
    data: () => ({
        user_roles: []
    }),
    mounted() {
        if(this.is_auth) {
            this.$store.dispatch('getAllRoles')
                .then(response => {
                    this.$store.dispatch('getRolesByUserId', this.$route.params.id)
                        .then(res => {
                            console.log(this.my_roles_formated)
                        })
                });

            this.$store.dispatch('getRolesByUserId', this.$route.params.id)
                .then(response => {
                    this.user_roles = response.data.data;
                });
        }
    },
    methods: {
        save() {
            this.$store.dispatch('setRoles', {user_id: this.$route.params.id, roles_ids: this.get_update_roles()})
                .then(response => {
                    console.log(response);
                })
        },
        get_update_roles() {
            const roles = this.$refs.roles;
            const result = [];
            roles.forEach(element => {
                if(element.checked) {
                    result.push(element.getAttribute('data-id'));
                }
            });
            return result;
        }
    },
    watch: {
        is_auth() {
            if(this.is_auth) {
                this.$store.dispatch('getAllRoles')
                    .then(response => {
                        this.$store.dispatch('getRolesByUserId', this.$route.params.id)
                    })
            }
        }
    },
    computed: {
        ...mapGetters([
            'is_auth',
            'roles'
        ]),
        user_roles_formated() {
            const roles = {};
            this.user_roles.forEach(el => {
                roles[el.slug] = el.name;
            })
            return roles;
        },
    },
    components: {
        ButtonGroup
    }
}
</script>

<style scoped>

</style>
