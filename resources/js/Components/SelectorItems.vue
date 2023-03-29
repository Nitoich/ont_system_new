<template>
    <div class="border-2 rounded-lg hover:border-slate-700 overflow-hidden min-h-[200px]">
        <ul>
            <li :class="value == key ? 'bg-second-blue' : ''" class="p-2 hover:bg-main-blue cursor-pointer" @click="selectItem($event, key)" :data-value="key" v-for="(item, key) in this.items">{{ item }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SelectorItems",
    props: {
        multiple: {
            type: Boolean,
            default: false
        },
        items: {
            type: Object,
            default: {}
        },
        value: {
            type: [String, Number],
            default: 0
        }
    },
    methods: {
        selectItem(event, key) {
            this.$emit('input', key)
        }
    }
}
</script>

<style scoped>

</style>
