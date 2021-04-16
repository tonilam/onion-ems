<template>
    <app-layout title="Clients">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <t-alert v-if="newClient" variant="success" show>
                        Client: <b>{{ newClient.name }}</b> created.
                    </t-alert>
                    <t-alert variant="warning" show>
                        <IconInfo primary="text-yellow-300" secondary="text-yellow-300" class="w-5 h-5 inline-block"/>
                        Under construction
                    </t-alert>
                    <t-table :headers="clientTable.headers" :data="clientTable.data">
                        <template v-slot:row="props">
                            <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-gray-100' : '']">
                                <td :class="props.tdClass">{{ props.row.name }}</td>
                                <td :class="props.tdClass">{{ props.row.contact }}</td>
                                <td :class="props.tdClass">{{ props.row.phone_number }}</td>
                                <td :class="props.tdClass">{{ props.row.status }}</td>
                                <td :class="props.tdClass" class="w-0.5">
                                    <div class="flex items-center">
                                        <t-button variant="primary_action" href="/dashboard">View</t-button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </t-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    export default {
        name: "ClientIndex",
        props: {
            newClient: {type: Object, required: false, default: () => {}}
        },
        data() {
            return {
                clientTable: {
                    headers: [
                        {value: 'name', text: 'Name'},
                        {value: 'contact', text: 'Contact'},
                        {value: 'phone_number', text: 'Phone No.'},
                        {value: 'status', text: 'Status'},
                        {value: 'action', text: ''},
                    ],
                    data: []
                }
            }
        },
        mounted() {
            this.$eventBus.$emit('page.changeTitle', 'Clients');
            this.fetchClients();
        },
        methods: {
            fetchClients() {
                axios.get('/api/clients').then(response => {
                    this.clientTable.data = response.data.data;
                });
            }
        }
    }
</script>
