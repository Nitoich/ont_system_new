<template>
    <div ref="main" tabindex="0" class="w-[200px] h-[46px] overflow-hidden">
        <div @click="focus" class="header mt-[12px] px-2">
            <span v-if="this.value">{{ this.items[this.value] }}</span>
            <text-input ref="searchElement" placeholder="Поиск" v-model="search"></text-input>
        </div>
        <div ref="itemsList" class="items">
            <div @click="selectItem($event, key)" :key="key" v-for="(item, key) in this.filteredItems" class="item hover:bg-second-blue cursor-pointer px-2">
                <span>{{ item }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import TextInput from "./Inputs/TextInput";

export default {
    name: "SmartSelect",
    props: {
        items: {
            type: Object,
        },
        value: {
            type: [Number, String],
        }
    },
    data: () => ({
        search: '',
    }),
    methods: {
        focus() {
            this.$refs.main.classList.remove('h-[46px]');
            this.$refs.main.classList.add('h-max');
            this.$refs.searchElement.$el.style.display = 'block';
            this.$refs.itemsList.style.display = 'block';
        },
        blur() {
            this.$refs.main.classList.add('h-[46px]');
            this.$refs.main.classList.remove('h-max');
            this.$refs.searchElement.$el.style.display = 'none';
            this.$refs.itemsList.style.display = 'none';
        },
        selectItem(event, key) {
            this.$emit('input', key);
            this.blur();
        }
    },
    components: {
        TextInput
    },
    computed: {
        filteredItems: {
            get() {
                const items = {};
                console.log(this.search);
                console.log(this.items)
                if(this.search == '') { return this.items; }
                for(const [key, name] of Object.entries(this.items)) {
                    if(name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1) {
                        items[key] = name;
                    }
                }
                console.log(items)
                return items;
            }
        },
    }
}
</script>

<style scoped>

</style>
