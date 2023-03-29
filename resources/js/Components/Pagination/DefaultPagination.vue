<template>
    <ol v-if="typeof this.paginationMeta !== 'undefined'" class="flex justify-center gap-1 text-xs font-medium">
        <template v-if="typeof paginationMeta.links !== 'undefined'" v-for="link in this.paginationMeta.links">
            <li v-if="link.url !== null">
                <a v-html="link.label" @click="$emit('click', $event, link)" :class="link.active ? 'bg-blue-600 border-blue-600 text-white' : 'border border-gray-100'" class="select-none block h-8 w-8 rounded text-center leading-8 cursor-pointer"></a>
            </li>
            <li v-html="link.label" v-else class="select-none block h-8 w-8 rounded text-center leading-8 border border-gray-100 cursor-pointer"></li>
        </template>
    </ol>
</template>

<script>
export default {
    name: "DefaultPagination",
    props: {
        paginationMeta: {}
    }
}
</script>

<style scoped>

</style>
