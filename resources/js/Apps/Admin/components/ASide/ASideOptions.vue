<template>
    <div class="w-[600px]">
        <h1 class="text-center text-2xl py-2">Настройки элементов меню</h1>
        <div class="grid grid-cols-4 gap-1">
            <h2>Элемент меню:</h2>
            <h2 class="col-span-3">Роли у которых есть доступ к разделу {{ selected_menu_item }}:</h2>
            <selector-items v-model="selected_menu_item" :items="this.menu_items_selector"></selector-items>
            <div class="roles border-2 col-span-3 hover:border-slate-700 rounded-lg p-2 grid grid-cols-2">
                <div v-for="role in this.roles">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input @click="clickCheckbox($event, role)" :checked="typeof options[selected_menu_item] !== 'undefined' && options[selected_menu_item].includes(role.slug)" :ref="`role_${role.slug}`" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ role.name }}</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="py-1.5 flex justify-end">
            <ButtonGroup :buttons="[
                {
                    name: 'Отменить',
                    cb: () => { this.$emit('close-popup'); }
                },
                {
                    name: 'Сохранить',
                    cb: save
                }
            ]" ></ButtonGroup>
        </div>
    </div>
</template>

<script>
import SelectorItems from "../../../../Components/SelectorItems.vue";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
import {mapGetters} from "vuex";
export default {
    name: "ASideOptions",
    data: () => ({
        selected_menu_item: 'home',
        options: {}
    }),
    created() {
        if(this.is_auth) {
            this.$store.dispatch('getAllRoles');
            this.$store.dispatch('getMenuItemAccess');
        }
    },
    computed: {
        ...mapGetters([
            'all_menu_items',
            'roles',
            'is_auth',
            'menu_items_access'
        ]),
        menu_items_selector() {
            const result = {};
            for(const [key, value] of Object.entries(this.all_menu_items)) {
                result[key] = value.name
            }
            return result;
        }
    },
    methods: {
        save(event) {
            this.$store.dispatch('setMenuItemAccess', this.options)
                .then(response => {
                    console.log(response);
                    this.$store.dispatch('getMenuItemAccess');
                    this.$emit('close-popup');
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
        clickCheckbox(event, role) {
            let item_roles = this.options[this.selected_menu_item];
            if(!event.target.checked) {
                item_roles = item_roles.filter(role_slug => role_slug !== role.slug);
            } else {
                if(typeof item_roles === 'undefined') {
                    item_roles = [role.slug];
                } else {
                    item_roles.push(role.slug);
                }
            }
            this.options[this.selected_menu_item] = item_roles;
        }
    },
    watch: {
        selected_menu_item() {
            // const menu_item_roles = this.options[this.selected_menu_item];
            // console.log(menu_item_roles);
            // if(typeof menu_item_roles === 'undefined') { return false; }
            // menu_item_roles.forEach(role => {
            //     const element = this.$refs[`role_${role}`];
            //     console.log(element);
            //     element.checked = true;
            // });
        },
        menu_items_access() {
            this.options = {...this.menu_items_access};
        }
    },
    components: {
        SelectorItems,
        ButtonGroup
    }
}
</script>

<style scoped>

</style>
