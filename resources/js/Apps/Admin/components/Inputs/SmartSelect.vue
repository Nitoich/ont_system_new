<template>
    <div ref="selector" :class="is_focus ? 'rounded-t-md' : 'rounded-md'" class="relative">
<!--        <input v-model="filter_query" class="w-full peer border-none focus:outline-none" @focus="focus" type="text" :placeholder="items[value]">-->
<!--        <div :class="is_focus ? 'rounded-b-md' : 'rounded-md'" v-if="is_focus" class="absolute left-0 top-100 bg-white z-10 border-2 user-select-none w-full h-[300px] overflow-auto">-->
<!--            <ul>-->
<!--                <li @click="itemClick($event, key)" class="hover:bg-slate-50 px-1 py-2 cursor-pointer" :key="key" v-for="(item, key) in this.filtered_items">{{ item }}</li>-->
<!--            </ul>-->
<!--        </div>-->
        <label
            for="UserEmail"
            class="relative block overflow-hidden rounded-md border border-gray-200 px-3 pt-3 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600"
        >
            <input
                type="text"
                @focus="focus"
                v-model="filter_query"
                :placeholder="this.items[value]"
                class="peer h-8 w-full border-none bg-transparent p-0 focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
            />

            <span
                :class="prepareClassesForPlaceholderSpan()"
                class="absolute left-3 top-3 -translate-y-1/2 text-gray-700 transition-all peer-focus:top-3 peer-focus:text-xs"
            >
                {{ this.placeholder }}
            </span>

        </label>
        <div :class="is_focus ? 'rounded-b-md' : 'rounded-md'" v-if="is_focus" class="absolute left-0 top-100 bg-white z-10 border-2 user-select-none w-full h-[200px] overflow-auto">
            <ul>
                <li @click="itemClick($event, key)" class="hover:bg-slate-50 px-1 py-2 cursor-pointer" :key="key" v-for="(item, key) in this.filtered_items">{{ item }}</li>
            </ul>
            <LoaderMini v-if="itemLoader" class="absolute top-0 left-0 w-full h-full bg-slate-500 bg-opacity-[.8]"></LoaderMini>
        </div>
    </div>
</template>

<script>
import LoaderMini from "../LoaderMini.vue";

export default {
    name: "SmartSelect",
    components: {LoaderMini},
    data: () => ({
        filter_query: '',
        is_focus: false
    }),
    methods: {
        prepareClassesForPlaceholderSpan() {
            const result = [];

            result.push('text-sm');
            if(this.value == '') {
                result.push('top-1/2');
                result.push('text-sm');
                result.push('top-3');
            }

            return result.join(' ');
        },
        focus(event) {
            this.is_focus = true;
            this.$emit('focus', event);
            document.addEventListener('click', this.documentClick)
        },
        documentClick(event) {
            const isSelector = event.composedPath().includes(this.$refs.selector);
            if(!isSelector) {
                this.blur(event);
                document.removeEventListener('click', this.documentClick)
            }
        },
        blur(event) {
            this.is_focus = false;
            this.$emit('blur', event);
        },
        itemClick(event, key) {
            this.$emit('input', key);
            this.filter_query = '';
            this.blur();
        }
    },
    computed: {
        filtered_items() {
            return Object.keys(this.items)
                .filter( key => this.items[key].toLowerCase().includes(this.filter_query.toLowerCase()))
                .reduce( (res, key) => {
                    res[key] = this.items[key];
                    return res;
                }, {});
        }
    },
    props: {
        value: {
            type: [String, Number, null],
            default: ''
        },
        items: {
            type: Object,
            default: () => ({})
        },
        placeholder: {
            type: String,
            default: ''
        },
        itemLoader: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>
