<template>
    <span class="inline-flex -space-x-px overflow-hidden rounded-md border bg-white shadow-sm">
        <button @click="button.cb" v-for="button in this.buttons" class="inline-block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:relative">
            {{ button.name }}
        </button>
    </span>
</template>

<script>
export default {
    name: "ButtonGroup",
    props: {
        buttons: {
            default: {}
        }
    }
}
</script>

<style scoped>

</style>
