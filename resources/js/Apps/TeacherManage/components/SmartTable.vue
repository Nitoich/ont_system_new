<template>
    <div>
        <table class="table-auto w-full">
            <thead class="bg-slate-100">
                <tr>
                    <th class="border border-slate-300 p-1.5 text-center" :key="key_header" v-for="(header, key_header) in this.headers">{{ header }}</th>
                </tr>
            </thead>
            <tbody>
                <tr class="cursor-pointer hover:bg-slate-50" @click="$emit('item-click', $event, item)" v-for="item in this.items">
                    <td v-for="(fields, key_fields) in headers" class="border border-slate-300 p-1.5 text-center">{{ item[key_fields] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "SmartTable",
    props: {
        headers: {
            type: Object,
            default: {}
        },
        items: {
            type: Array,
        }
    },

}
</script>

<style scoped>

</style>
