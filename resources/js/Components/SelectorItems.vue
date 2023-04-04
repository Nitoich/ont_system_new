<template>
    <div class="border-2 rounded-lg hover:border-slate-700 overflow-hidden min-h-[200px]">
        <ul>
            <li :class="(multiple ? selected_items.includes(key) : value == key) ? 'bg-second-blue' : ''" class="p-2 hover:bg-main-blue cursor-pointer" @click="selectItem($event, key)" :data-value="key" v-for="(item, key) in this.items">{{ item }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SelectorItems",
    data: () => ({
        selected_items: []
    }),
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
            type: [String, Number, Array],
            default: 0
        }
    },
    methods: {
        selectItem(event, key) {
            if(this.multiple) {
                if(this.selected_items.includes(key)) {
                    this.$set(this, 'selected_items', this.selected_items.filter((item) => {
                        if(item != key) {
                            return item;
                        }
                    }));
                } else {
                    this.selected_items.push(key);
                }
                this.$emit('input', this.selected_items);
            } else {
                this.$emit('input', key)
            }
        }
    },
    watch: {
        value() {
            if(this.multiple) {
                this.selected_items = this.value;
            }
        }
    }
}
</script>

<style scoped>

</style>
