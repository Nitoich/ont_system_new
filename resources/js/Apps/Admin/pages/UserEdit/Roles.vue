<template>
    <div>
        <div class="roles">
            <div v-for="role in this.roles" class="role">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" :checked="typeof my_roles_formated[role.slug] !== 'undefined'">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ role.name }}</span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "Roles",
    mounted() {
        if(this.is_auth) {
            this.$store.dispatch('getAllRoles')
                .then(response => {
                    this.$store.dispatch('getRolesByUserId', this.$route.params.id)
                        .then(res => {
                            console.log(this.my_roles_formated)
                        })
                });
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
            'my_roles_formated',
            'roles'
        ])
    }
}
</script>

<style scoped>

</style>
