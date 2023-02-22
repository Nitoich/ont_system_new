<template>
    <div class="input w-[200px] min-h-[40px] position-relative p-2">
        <div class="absolute-block relative min-h-[30px]">
            <span ref="placeholder" class="absolute top-[5%] transition-all duration-500 px-2 user-select-none">{{ this.placeholder }}</span>
            <input
                :class="this.error !== '' ? 'border-red-500' : ''"
                class="px-2 outline-0 bg-transparent border-b-2 absolute"
                @blur="this.blur"
                @focus="this.focus"
                :value="this.value"
                @input="$emit('input', $event.target.value)"
                :type="this.isPassword ? 'password' : 'text'">
        </div>
        <span class="text-danger block" v-if="this.error !== ''">{{ this.error }}</span>
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
        },
        error: {
            type: String,
            default: ''
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
            if(this.value == '') {
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
