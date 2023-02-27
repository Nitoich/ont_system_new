<template>
    <div>
        <div v-if="errors" role="alert" class="rounded border-l-4 border-red-500 bg-red-50 p-4">
            <strong class="block font-medium text-red-800"> Something went wrong </strong>

            <p class="mt-2 text-sm text-red-700">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo quasi
                assumenda numquam deserunt consectetur autem nihil quos debitis dolor culpa.
            </p>
        </div>
        <div class="fields" v-if="user">
            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">ID:</span>
                <span>{{ user.id }}</span>
            </div>

            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">EMAIL:</span>
                <text-input v-model="user.email"></text-input>
            </div>

            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">Фамилия:</span>
                <text-input v-model="user.last_name"></text-input>
            </div>

            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">Имя:</span>
                <text-input v-model="user.first_name"></text-input>
            </div>

            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">Отчество:</span>
                <text-input v-model="user.surname"></text-input>
            </div>

            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">Дата рождения:</span>
                <text-input v-model="user.birth_day"></text-input>
            </div>
        </div>
        <div class="text-center">
            <button-group
                :buttons="{
                save: {
                    name: 'Сохранить',
                    cb: () => {}
                },
                accept: {
                    name: 'Принять',
                    cb: () => {}
                },
                cancel: {
                    name: 'Отменить',
                    cb: () => {}
                }
            }"
            ></button-group>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import TextInput from "../../../../Components/Inputs/TextInput";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup";

export default {
    name: "General",
    data: () => ({
        user: null,
        errors: null
    }),
    mounted() {
        if(this.is_auth) {
            this.getUser();
        }
    },
    methods: {
        getUser() {
            this.$store.dispatch('getUser', this.$route.params.id)
                .then(response => {
                    this.user = response.data.data;
                });
        }
    },
    watch: {
        is_auth() {
            if(this.is_auth) {
                this.getUser();
            }
        }
    },
    components: {
        TextInput,
        ButtonGroup
    },
    computed: {
        ...mapGetters([
            'is_auth'
        ])
    }
}
</script>

<style scoped>

</style>
