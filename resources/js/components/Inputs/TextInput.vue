<template>
    <div class="input min-w-[200px] min-h-[40px] position-relative p-2">
        <span ref="placeholder" class="position-absolute top-[25%] transition-all duration-500 px-2 user-select-none">{{ this.placeholder }}</span>
        <input
            class="px-2 outline-0 bg-transparent border-b-2 position-absolute"
            @blur="this.blur"
            @focus="this.focus"
            :value="this.value"
            @input="$emit('input', $event.target.value)"
            :type="this.isPassword ? 'password' : 'text'">
    </div>
</template>

<script>
export default {
    name: "TextInput",
    props: {
        value: {
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: ''
        },
        isPassword: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        focus(event) {
            this.$refs.placeholder.classList.add('text-xs');
            this.$refs.placeholder.classList.add('top-[0]');
            this.$refs.placeholder.classList.add('pl-1');
            this.$refs.placeholder.classList.add('text-gray-300');
            this.$refs.placeholder.classList.remove('top-[25%]');
        },
        blur() {
            if(this.value == '') {
                this.$refs.placeholder.classList.add('top-[25%]');
                this.$refs.placeholder.classList.remove('text-xs');
                this.$refs.placeholder.classList.remove('top-[0]');
                this.$refs.placeholder.classList.remove('text-gray-300');
                this.$refs.placeholder.classList.remove('pl-1');
            }
        }
    }
}
</script>

<style scoped>

</style>
