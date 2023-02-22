<template>
    <div class="flex justify-center items-center flex-col mt-24">
        <h1 class="text-2xl font-bold text-gray-700">HOME</h1>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: "Index",
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    }
}
</script>

<style scoped>

</style>
