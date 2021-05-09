<template>
    <v-container :fluid="false">
        <v-card>
            <v-card-text>
                <h3 class="card-title"><v-icon color="green darken-3">mdi-card-text</v-icon> Contacts</h3>
                <v-data-table :headers="contacts.headers"
                :items="contacts.data"
                :items-per-page="parseInt(contacts.meta.per_page)"
                :server-items-length="contacts.meta.total"
                :loading="contacts.loading"
                @update:page="fetchContacts({page: $event})"
                @update:items-per-page="fetchContacts({per_page: $event})"></v-data-table>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        name: 'ContactInfoCard',
        props: {
            companyId: {type: Number, required: false, default: null},
            personId: {type: Number, required: false, default: null},
        },
        data() {
            return {
                contacts: {
                    headers: [
                        {value: 'type', text: 'Type', sortable: false},
                        {value: 'content', text: 'Content', sortable: false},
                    ],
                    data: [],
                    meta: {
                        per_page: 10,
                    },
                    loading: false,
                }
            }
        },
        mounted() {
            this.fetchContacts();
        },
        methods: {
            fetchContacts(params) {
                this.contacts.loading = true;
                axios.get(`/contacts`, {
                    params: {
                        company_id: this.companyId,
                        person_id: this.personId,
                        per_page: this.contacts.meta.per_page,
                        ...params
                    }
                }).then(response => {
                    this.contacts.data = response.data.data;
                    this.contacts.meta = response.data.meta;
                }).catch(() => {

                }).finally(() => {
                    this.contacts.loading = false;
                });
            },
        }
    }
</script>
