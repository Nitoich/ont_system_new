<template>
    <button @click="$emit('click', $event)" class="px-2 py-1 bg-main-blue text-white hover:bg-second-blue">
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
