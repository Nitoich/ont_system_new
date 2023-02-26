<template>
    <div class="aside min-w-[75px] h-screen bg-slate-500 border-r-4 border-slate-800">
        <div class="aside__list">
            <div :class="$route.name == key ? 'bg-slate-600' : ''" @click="$router.push(item.url)" v-for="(item, key) in menu_items" class="aside__item p-2 flex flex-col justify-center items-center gap-1 hover:bg-slate-600 cursor-pointer">
                <div :style="`background-image: url('${item.icon}');`" class="icon w-[50px] h-[50px] bg-cover bg-no-repeat bg-center"></div>
                <p class="text-xs">{{ item.name }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ASide",
    data: () => ({
        menu_items: {
            home: { name: 'Главная', icon: '/images/admin/icon_home.png', url: '/admin/home' },
            users: { name: 'Пользователи', icon: '/images/admin/users.png', url: '/admin/users' },
            d: { name: 'Главная', icon: '/images/admin/icon_home.png', url: '/admin/' },
        }
    })
}
</script>

<style scoped>

</style>
