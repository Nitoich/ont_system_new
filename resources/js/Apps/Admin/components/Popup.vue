<template>
    <div @mousedown.self.passive="closePopup" v-if="this.value" class="z-20 overview h-screen w-screen bg-[#000000aa] fixed left-0 top-0 flex justify-center items-center">
        <div class="content min-h-[200px] min-w-[400px] bg-white p-3 rounded-lg">
            <component v-bind="this.props" @close-popup="closePopup" :is="this.component"></component>
        </div>
        <div @click="closePopup" class="group cross absolute top-[2%] right-[2%] w-[50px] h-[50px] flex justify-center items-center cursor-pointer">
            <div class="relative w-[50px] h-[50px]">
                <span class="bg-slate-100 group-hover:bg-slate-400 block w-[45px] h-[5px] absolute top-[50%] left-50% translate-x-[50%] translate-y-[50%] rotate-45"></span>
                <span class="bg-slate-100 group-hover:bg-slate-400 block w-[45px] h-[5px] absolute top-[50%] left-50% translate-x-[50%] translate-y-[50%] -rotate-45"></span>
            </div>
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
        props: {
            type: Object,
            default: () => ({})
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
