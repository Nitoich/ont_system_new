<template>
    <button @click="$emit('click', $event)" class="px-xl-3 py-1 bg-success">
        {{ this.label }}
    </button>
</template>

<script>
export default {
    name: "StandardButton",
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
