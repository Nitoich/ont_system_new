<template>
    <div class="bg-home min-h-screen bg-no-repeat bg-cover bg-center">
        <div class="min-h-screen bg-[#5cb48e66] flex flex-col">
            <header class="bg-[#000000aa] py-3 text-white">
                <div class="container mx-auto flex justify-between">
                    <span>Электронный дневник Орского нефтяного техникума</span>
                    <span>Телефон: (3537)21-66-29</span>
                </div>
            </header>
            <main class="flex-1 flex justify-center items-center container mx-auto max-w-[1000px] gap-[20px]">
                <div class="content flex-1">
                    <router-view></router-view>
                </div>
                <div class="navigation flex flex-col gap-2">
                    <navigation-button :key="item.path" v-for="item in this.navigation" :label="item.label" :image="item.image" :path="item.path"></navigation-button>
                </div>
            </main>
            <footer class="bg-[#000000aa] py-3 text-white">
                <div class="container mx-auto flex justify-center">
                    <span>Copyright © 2023 И.В.Финк</span>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import NavigationButton from "../components/NavigationButton";

export default {
    name: "application",
    data: () => ({
        navigation: [
            {
                label: 'Главная',
                image: '/images/home/home.png',
                path: '/'
            },
            {
                label: 'Что-то важное',
                image: '',
                path: '/any1'
            },
            {
                label: 'Что-то важное',
                image: '',
                path: '/any2'
            },
            {
                label: 'Что-то важное',
                image: '',
                path: '/any3'
            },

        ]
    }),
    mounted() {

    },
    components: {
        NavigationButton
    }
}
</script>

<style scoped>

</style>
