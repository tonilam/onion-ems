<template>
    <app-layout :title="client.name">
        <v-tabs v-model="tab"
            flat
            background-color="indigo"
            dark>
            <v-tab>
                Client Info
            </v-tab>
            <v-tab v-show="client.person_id">
                Person
            </v-tab>
            <v-tab v-show="client.company_id">
                Company
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
            <v-tab-item key="Client">
                <client-info-card :client="client"></client-info-card>
            </v-tab-item>
            <v-tab-item key="Person">
                <person-info-card v-show="client.person_id" :person-id="client.person_id"></person-info-card>
                <contact-info-card :person-id="client.person_id"></contact-info-card>
            </v-tab-item>
            <v-tab-item key="Company">
                <company-info-card v-show="client.company_id" :company-id="client.company_id"></company-info-card>
                <contact-info-card :company-id="client.company_id"></contact-info-card>
            </v-tab-item>
        </v-tabs-items>

    </app-layout>
</template>

<script>
    import ClientInfoCard from '@/Components/Cards/ClientInfoCard';
    import CompanyInfoCard from '@/Components/Cards/CompanyInfoCard';
    import ContactInfoCard from '@/Components/Cards/ContactInfoCard';
    import PersonInfoCard from '@/Components/Cards/PersonInfoCard';

    export default {
        name: "ClientView",
        components: {
            ClientInfoCard,
            CompanyInfoCard,
            ContactInfoCard,
            PersonInfoCard
        },
        props: {
            client: {type: Object, required: true},
        },
        data() {
            return {
                tab: 'Client'
            }
        },
        created() {
            this.$eventBus.$on('client.reload', this.fetchClient);
        },
        mounted() {
        },
        beforeDestroy() {
            this.$eventBus.$off('client.reload', this.fetchClient);
        },
        methods: {
            fetchClient() {
                this.$inertia.reload({only: ['client']});
            },
        }
    }
</script>
