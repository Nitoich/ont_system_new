<template>
    <div class="p-3 bg-white">
        <div class="fields flex flex-col items-center gap-2" v-if="fields">
            <div class="field grid grid-cols-2 items-center">
                <span class="text-right">ID:</span>
                <span>{{ fields.id }}</span>
            </div>

            <div class="w-[370px]">
                <TextInput v-model="fields.name" placeholder="Название"></TextInput>
            </div>

            <div class="w-[370px]">
                <TextInput v-model="fields.slug" placeholder="Код"></TextInput>
            </div>
        </div>
        <div class="text-center mt-2">
            <ButtonGroup
                :buttons="[
                    {
                        name: 'Сохранить',
                        cb: () => {}
                    },
                    {
                        name: 'Применить',
                        cb: () => {}
                    },
                    {
                        name: 'Отменить',
                        cb: () => {}
                    },
                    {
                        name: 'Удалить',
                        cb: () => {}
                    }
                ]"
            ></ButtonGroup>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import TextInput from "../../../../Components/Inputs/TextInput.vue";
import ButtonGroup from "../../../../Components/Buttons/ButtonGroup.vue";

export default {
    name: "Role",
    data: () => ({
        fields: undefined,
    }),
    created() {
        // console.log(this.$route)
        if(this.is_auth) {
            this.$store.dispatch('getRole', this.$route.params.id)
                .then(({ data }) => {
                    this.fields =  data.data;
                })
        }
    },

    computed: {
        ...mapGetters([
            'is_auth'
        ])
    },
    components: {
        TextInput,
        ButtonGroup
    }
}
</script>

<style scoped>

</style>
