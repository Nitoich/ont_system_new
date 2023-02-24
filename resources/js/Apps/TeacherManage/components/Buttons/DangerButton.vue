<template>
    <button @click="$emit('click', $event)" class="px-2 py-1 bg-red-600 text-white hover:bg-red-400">
        {{ this.label }}
    </button>
</template>

<script>
export default {
    name: "DangerButton",
    props: {
        label: {
            type: String,
            default: 'button'
        }
    }
}
</script>

<style scoped>

</style>

