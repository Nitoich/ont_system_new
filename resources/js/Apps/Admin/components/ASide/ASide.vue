<template>
    <div class="aside min-w-[75px] h-screen border-r-4 border-slate-800">
        <nav aria-label="Main Nav" class="flex flex-col">
            <a @click="$event.preventDefault(); $router.push(item.url)" v-for="(item, key) in menu_items" :class="$route.meta.page_group == key ? 'flex items-center gap-2 border-l-[3px] border-blue-500 bg-blue-50 px-4 py-3 text-blue-700 cursor-pointer' : 'flex items-center gap-2 border-l-[3px] border-transparent px-4 py-3 text-gray-500 hover:border-gray-100 hover:bg-gray-50 hover:text-gray-700 cursor-pointer'" class="">
                <span class="text-sm font-medium"> {{ item.name }} </span>
            </a>
        </nav>
    </div>
</template>

<script>
export default {
    name: "ASide",
    data: () => ({
        menu_items: {
            home: { name: 'Главная', url: '/admin/home' },
            users: { name: 'Пользователи', url: '/admin/users' },
            loads: { name: 'Нагрузка', url: '/admin/loads' },
            groups: { name: 'Группы', url: '/admin/groups' },
            discipline: { name: 'Дисциплины', url: '/admin/disciplines' },
            roles: { name: 'Роли', url: '/admin/roles' },
        }
    })
}
</script>

<style scoped>

</style>
