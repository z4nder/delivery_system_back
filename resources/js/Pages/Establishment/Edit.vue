<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Estabelecimento
            </h2>
            <inertia-link :href="route('indexEstablishment')" >
                <jet-button >
                    Voltar
                </jet-button>
            </inertia-link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <establishment-form :isEdit="true" :editData="$page.establishment"/>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <address-form :establishment="$page.establishment.data"/>
                </div>
            </div>
        </div>

         <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <opening-hours-form />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstablishmentForm from './EstablishmentForm'
    import JetButton from "@/Jetstream/Button";
    import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";

    import AddressForm from '../Address/AddressForm'
    import OpeningHoursForm from '../OpeningHours/OpeningHoursForm'
    export default {
        props: ["establishment"],
        components: {
            AppLayout,
            EstablishmentForm,
            JetButton,
            JetResponsiveNavLink,
            AddressForm,
            OpeningHoursForm
        },
    }
</script>
