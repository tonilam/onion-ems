<template>
    <app-layout title="Clients">
        <v-container :fluid="false">
            <v-card>
                <v-card-text>
                    <v-data-table :headers="clientsTable.headers"
                        :items="clients.data"
                        :items-per-page="10"
                        :search="clientsTable.search">
                        <template v-slot:top>
                            <v-text-field
                                v-model="clientsTable.search"
                                label="Search"
                                append-icon="mdi-magnify"
                                class="mx-4"
                            ></v-text-field>
                        </template>
                        <template v-slot:item.linked_name="{ item }">
                            <span v-if="item.company_id"><v-chip small color="info">B</v-chip> {{ item.linked_name }}</span>
                            <span v-if="item.person_id"><v-chip small color="cyan">I</v-chip> {{ item.linked_name }}</span>
                        </template>
                        <template v-slot:item.action="{ item }" width="1%">
                            <div class="flex items-center">
                                <v-btn small color="primary" :href="`/clients/${item.id}`">
                                    View
                                </v-btn>
                            </div>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </app-layout>
</template>

<script>
    export default {
        name: "ClientIndex",
        props: {
            clients: {type: Object, required: false, default: () => {}},
        },
        data() {
            return {
                clientsTable: {
                    headers: [
                        {value: 'name', text: 'Name'},
                        {value: 'linked_name', text: 'Business/Individual'},
                        {value: 'status', text: 'Status'},
                        {value: 'action', text: ''},
                    ],
                    search: '',
                }
            }
        },
    }
</script>
