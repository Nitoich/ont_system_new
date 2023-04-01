<template>
    <div class="flex flex-col gap-2">
        <h1 class="text-xl text-center">Новая роль</h1>
        <div class="errors" v-if="errors">
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Danger</span>
                <div>
                    <span class="font-medium">Ошибка валидации:</span>
                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                        <li v-for="error in errors">{{ error[0] }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <TextInput v-model="fields.name" placeholder="Название"></TextInput>
        <TextInput v-model="fields.slug" placeholder="Код"></TextInput>
        <ButtonGroup class="w-full mt-[30px] justify-around" :buttons="[{ name: 'Отмена', cb: () => { this.$emit('close-popup'); } }, { name: 'Создать', cb: create } ]"></ButtonGroup>
    </div>
</template>

<script>
import TextInput from "../../../../Components/Inputs/TextInput.vue";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";
export default {
    name: "CreateRole",
    components: {
        TextInput,
        ButtonGroup
    },
    data: () => ({
        fields: {
            name: 'Новая роль',
            slug: 'role'
        },
        errors: null
    }),
    methods: {
        create() {
            this.errors = null;
            this.$store.dispatch('createRole', this.fields)
                .then(response => {
                    this.$emit('close-popup');
                    this.$store.dispatch('getAllRoles')
                }).catch((error) => {
                    const response = error.response;
                    if(response.status == 422) {
                        this.errors = response.data.error.errors;
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
