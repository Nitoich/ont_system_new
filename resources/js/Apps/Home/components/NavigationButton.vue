<template>
    <div v-if="this.condition || typeof this.condition === 'undefined'" @click="click" class="flex flex-col justify-center items-center h-[100px] w-[100px] select-none cursor-pointer hover:bg-white hover:shadow-2xl transition-all">
        <div :style="`background-image: url('${this.image}');`" class="bg-no-repeat bg-cover h-[50px] w-[50px]"></div>
        <span class="text-center">{{ this.label }}</span>
    </div>
</template>

<script>
export default {
    name: "NavigationButton",
    props: {
        image: {
            type: String,
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        path: {
            type: String,
            default: '/'
        },
        condition: {
            type: Boolean,
            default: true
        }
    },
    methods: {
        click(event) {
            this.$router.push(this.path);
        }
    }
}
</script>

<style scoped>

</style>
