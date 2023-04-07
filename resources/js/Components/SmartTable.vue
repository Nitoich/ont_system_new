<template>
    <div>
        <table class="table-auto w-full">
            <thead class="bg-slate-100">
                <tr>
                    <th @click="selectAll" class="border border-slate-300 p-1.5 text-center relative" v-if="canSelect">
                        <input type="checkbox" :checked="value.length === items.length">
                        <div class="overlay absolute w-full h-full top-0 left-0"></div>
                    </th>
                    <th class="border border-slate-300 p-1.5 text-center" :key="key_header" v-for="(header, key_header) in this.headers">{{ header }}</th>
                </tr>
            </thead>
            <tbody>
                <tr @click="selectItem($event, item_index)" class="cursor-pointer hover:bg-slate-50" v-for="(item, item_index) in this.items">
                    <td class="border border-slate-300 p-1.5 text-center relative" v-if="canSelect">
                        <input type="checkbox" :checked="value.includes(item_index)">
                        <div class="overlay absolute w-full h-full top-0 left-0"></div>
                    </td>
                    <td v-for="(fields, key_fields) in headers" class="border border-slate-300 p-1.5 text-center">
                        <template v-if="typeof linkColumns !== 'undefined' && typeof linkColumns[key_fields] !== 'undefined'">
                            <router-link class="text-blue-400 underline" :to="linkColumns[key_fields](item)">{{ item[key_fields] }}</router-link>
                        </template>
                        <template v-else>
                            {{ item[key_fields] }}
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "SmartTable",
    methods: {
        selectAll(event) {
            const new_value = [];
            if(this.value.length !== this.items.length) {
                this.items.forEach((item, index) => {
                    new_value.push(index);
                    this.$emit('item-click', event, item);
                })
            }
            this.$emit('input', new_value);
        },
        selectItem(event, item_index) {
            if(this.value.includes(item_index)) {
                this.$emit('input', [...(this.value.filter(item => item !== item_index))]);
            } else {
                const new_value = [...this.value];
                new_value.push(item_index);
                this.$emit('input', new_value);
            }
            this.$emit('item-click', event, this.items[item_index]);
        }
    },
    props: {
        value: {
            type: Array,
            default: () => ([])
        },
        headers: {
            type: Object,
            default: {}
        },
        items: {
            type: Array,
        },
        linkColumns: {
            type: [Object, undefined],
            default: undefined
        },
        canSelect: {
            type: Boolean,
            default: false
        }
    },

}
</script>

<style scoped>

</style>
