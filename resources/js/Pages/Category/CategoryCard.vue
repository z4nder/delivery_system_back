<template>
    <div class="card ext-white m-3" style="max-width: 18rem;">
        <img :src="photo" id="category-card" class="card-img-top" :class="{ desable_img: !enable }" :alt="name" />
        <div class="card-body">
            <div id="category-card-actions" style="">
                <p class="card-text">{{ name }}</p>
                <jet-dropdown align="right" width="48">
                    <template #trigger>
                        <jet-secondary-button >
                            Ações
                        </jet-secondary-button>
                    </template>

                    <template #content>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Escolha uma ação
                        </div>
                        <jet-dropdown-link :href="route('editCategory', id)">
                            Editar
                        </jet-dropdown-link>
                        <span  @click="enableDisable(id)">
                            <jet-dropdown-link as="button">
                                    {{enable ? "Desabilitar": "Habilitar"}}
                            </jet-dropdown-link>
                        </span>
                        <span @click="actionDelete(id)">
                            <jet-dropdown-link as="button">
                                    Remover
                            </jet-dropdown-link>
                        </span>
                    </template>
                </jet-dropdown>
            </div>
        </div>
    </div>
</template>

<script>
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";

export default {
    props: ["name", "photo", "id", "enable"],
    components: {
        JetSecondaryButton,
        JetDropdown,
        JetDropdownLink
    },
    computed: {},
    methods: {
        async actionDelete(id){
           this.$emit('confirm-delete');
        },
        async enableDisable(id){
            await this.$inertia.post(route("enableDisableCategory", id))
        }
    }
};
</script>

<style scoped>
.desable_img {
    opacity: 0.2;
    filter: alpha(opacity=20); /* msie */
    background-color: #000;
}
#category-card-actions {
   display: flex;
   justify-content: center;
   align-items: center;
   flex-direction: column;
}
#category-card {
    width: 300px;
    height: 200px;
}
</style>
