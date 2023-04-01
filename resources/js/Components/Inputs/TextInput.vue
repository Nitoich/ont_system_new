<template>

    <label
        for="UserEmail"
        class="relative block overflow-hidden rounded-md border border-gray-200 px-3 pt-3 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
    >
        <input
            :disabled="this.disabled"
            :type="this.isPassword ? 'password' : 'text'"
            @input="$emit('input', $event.target.value)" :value="this.value"
            :placeholder="this.placeholder"
            class="peer h-8 w-full border-none bg-transparent p-0 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
        />

        <span
            class="absolute left-3 top-3 -translate-y-1/2 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-3 peer-focus:text-xs"
        >
    {{ this.placeholder }}
  </span>
    </label>

<!--    <label for="UserEmail" class="relative block overflow-hidden border-b border-gray-200 focus-within:border-blue-600">-->
<!--        <input :disabled="this.disabled" @input="$emit('input', $event.target.value)" :value="this.value" :type="this.isPassword ? 'password' : 'text'" :placeholder="this.placeholder" class="peer h-8 w-full border-none bg-transparent p-0 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm" />-->
<!--        <span class="absolute left-0 top-2 -translate-y-1/2 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">-->
<!--            {{ this.placeholder }}-->
<!--        </span>-->
<!--    </label>-->

<!--    <div class="input w-[200px] min-h-[40px] position-relative p-2">-->
<!--        <div class="absolute-block relative min-h-[30px]">-->
<!--            <span ref="placeholder" class="absolute top-[5%] transition-all duration-500 px-2 user-select-none">{{ this.placeholder }}</span>-->
<!--            <input-->
<!--                :disabled="this.disabled"-->
<!--                :class="this.error !== '' ? 'border-red-500' : ''"-->
<!--                class="px-2 outline-0 bg-transparent border-b-2 absolute"-->
<!--                @blur="this.blur"-->
<!--                @focus="this.focus"-->
<!--                :value="this.value"-->
<!--                @input="$emit('input', $event.target.value)"-->
<!--                :type="this.isPassword ? 'password' : 'text'">-->
<!--        </div>-->
<!--        <span class="text-danger block" v-if="this.error !== ''">{{ this.error }}</span>-->
<!--    </div>-->
</template>

<script>
export default {
    name: "TextInput",
    props: {
        value: {
            type: [String, Number],
            default: ''
        },
        placeholder: {
            type: String,
            default: ''
        },
        isPassword: {
            type: Boolean,
            default: false
        },
        error: {
            type: String,
            default: ''
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        focus(event) {
            this.$refs.placeholder.classList.add('text-xs');
            this.$refs.placeholder.classList.add('-top-[20%]');
            this.$refs.placeholder.classList.add('pl-1');
            this.$refs.placeholder.classList.add('text-gray-300');
            this.$refs.placeholder.classList.remove('top-[5%]');
        },
        blur() {
            if(this.value == '' || this.value == null) {
                this.$refs.placeholder.classList.add('top-[5%]');
                this.$refs.placeholder.classList.remove('text-xs');
                this.$refs.placeholder.classList.remove('-top-[20%]');
                this.$refs.placeholder.classList.remove('text-gray-300');
                this.$refs.placeholder.classList.remove('pl-1');
            }
        }
    }
}
</script>

<style scoped>

</style>
