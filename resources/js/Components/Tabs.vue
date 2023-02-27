<template>
    <div class="py-2">

        <ul class="flex border-b border-gray-200 text-center">
            <li class="flex-1 cursor-pointer" v-for="(tab, key) in this.tabs">
                <a v-if="key == $route.name" @click="$event.preventDefault(); $router.push({name: key, params: { id: $route.params.id }})"  class="relative block border-t border-l border-r border-gray-200 bg-white p-4 text-sm font-medium">
                    <span class="absolute inset-x-0 -bottom-px h-px w-full bg-white"></span>
                    {{ tab }}
                </a>
                <a @click="$event.preventDefault(); $router.push({name: key, params: { id: $route.params.id }})" v-else class="block bg-gray-100 p-4 text-sm font-medium text-gray-500 ring-1 ring-inset ring-white">
                    {{ tab }}
                </a>
            </li>
        </ul>


<!--        <div class="tabs flex gap-1">-->
<!--            <div @click="" :class="key == $route.name ? 'bg-white' : 'bg-slate-400'"  class="tab rounded-t px-1 cursor-pointer border-t-2 border-r-2 border-l-2 border-slate-600">-->
<!--                <span>{{ tab }}</span>-->
<!--            </div>-->
<!--        </div>-->
        <div class="content bg-white p-1">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "Tabs",
    props: {
        tabs: {}
    }
}
</script>

<style scoped>

</style>
