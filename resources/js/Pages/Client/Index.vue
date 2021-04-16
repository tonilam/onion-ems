<template>
    <app-layout title="Clients">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <t-alert v-if="created" variant="success" show>
                        Client: <b>{{ created.name }}</b> created.
                    </t-alert>
                    <t-table :headers="clientsTable.headers" :data="clients.data">
                        <template v-slot:row="props">
                            <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-gray-100' : '']">
                                <td :class="props.tdClass">{{ props.row.name }}</td>
                                <td :class="props.tdClass">{{ props.row.status }}</td>
                                <td :class="props.tdClass" class="w-0.5">
                                    <div class="flex items-center">
                                        <t-button variant="primary_action" :href="`/clients/${props.row.id}`">View</t-button>
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
            clients: {type: Array, required: false, default: () => []},
            created: {type: Object, required: false, default: () => {}}
        },
        data() {
            return {
                clientsTable: {
                    headers: [
                        {value: 'name', text: 'Name'},
                        {value: 'status', text: 'Status'},
                        {value: 'action', text: ''},
                    ],
                }
            }
        },
    }
</script>
