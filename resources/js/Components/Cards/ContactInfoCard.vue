<template>
    <v-container :fluid="false">
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col>
                        <v-flex>
                            <h3 class="card-title"><v-icon color="green darken-3">mdi-card-text</v-icon> Contacts</h3>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click.prevent="show_modal = 'create-contact-dialog'">Add</v-btn>
                        </v-flex>
                    </v-col>
                </v-row>
                <v-data-table :headers="contacts.headers"
                    :items="contacts.data"
                    :items-per-page="parseInt(contacts.meta.per_page)"
                    :server-items-length="contacts.meta.total"
                    :loading="contacts.loading"
                    @update:page="fetchContacts({page: $event})"
                    @update:items-per-page="fetchContacts({per_page: $event})">
                    <template v-slot:item.label="{ item }">
                        <v-chip v-if="item.label"
                            color="cyan lighten-4">
                            {{ item.label }}
                        </v-chip>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        <create-contact-dialog :show="show_modal === 'create-contact-dialog'"
            :company-id="companyId"
            :person-id="personId"
            @close="show_modal = null"
            @success="fetchContacts">
        </create-contact-dialog>
    </v-container>
</template>

<script>
    import CreateContactDialog from '@/Components/Dialogs/CreateContact';

    export default {
        name: 'ContactInfoCard',
        components: {
            CreateContactDialog
        },
        props: {
            companyId: {type: Number, required: false, default: null},
            personId: {type: Number, required: false, default: null},
        },
        data() {
            return {
                contacts: {
                    headers: [
                        {value: 'type', text: 'Type', sortable: false, width: '8em'},
                        {value: 'label', text: 'Label', sortable: false, width: '12em'},
                        {value: 'content', text: 'Content', sortable: false, width: '100%'},
                    ],
                    data: [],
                    meta: {
                        per_page: 10,
                    },
                    loading: false,
                },
                show_modal: null,
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
