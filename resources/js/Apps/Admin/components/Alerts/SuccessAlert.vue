<template>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-medium">{{ this.title }}</span> {{ this.message }}
    </div>
</template>

<script>
export default {
    name: "SuccessAlert",
    props: {
        title: {
            type: String,
            default: ''
        },
        message: {
            type: String,
            default: ''
        }
    }
}
</script>

<style scoped>

</style>
