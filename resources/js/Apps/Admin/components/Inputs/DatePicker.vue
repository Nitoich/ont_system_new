<template>
    <div class="relative">
        <label
            for="UserEmail"
            class="relative block overflow-hidden rounded-md border border-gray-200 px-3 pt-3 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
            data-te-datepicker-init
            data-te-input-wrapper-init
        >
            <input
                type="date"
                @input="$emit('input', $event.target.value)" :value="this.value"
                :placeholder="this.placeholder"
                class="peer h-8 w-full border-none bg-transparent p-0 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
                data-te-datepicker-toggle-ref
                data-te-datepicker-toggle-button-ref
            />

            <span
                class="absolute left-3 top-3 -translate-y-1/2 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-3 peer-focus:text-xs"
            >
    {{ this.placeholder }}
  </span>
        </label>
    </div>
</template>

<script>
export default {
    name: "DatePicker",
    created() {
        this.$emit('input', Date.now());
    },
    props: {
        placeholder: {
            type: String,
            default: ''
        },
        value: {}
    }
}
</script>

<style scoped>

</style>
