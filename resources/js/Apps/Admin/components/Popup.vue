<template>
    <div @click.self="closePopup" v-if="this.value" class="overview h-screen w-screen bg-[#000000aa] fixed left-0 top-0 flex justify-center items-center">
        <div class="content min-h-[200px] min-w-[400px] bg-white p-3 rounded-lg">
            <component :is="this.component"></component>
        </div>
    </div>
</template>

<script>
export default {
    name: "Popup",
    props: {
        component: {
            type: Object,
            default: () => ({
                template: "<div><h1>Popup</h1></div>"
            })
        },
        value: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        closePopup(event) {
            this.$emit('input', false);
        }
    }
}
</script>

<style scoped>

</style>
