<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Client
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg in">
                    <div v-if="clientForm.status.submitted">
                        <t-alert v-if="clientForm.status.result" variant="success" show @hidden="resetForm">Client created at {{ clientForm.data.created_at }}.</t-alert>
                        <t-alert v-else variant="danger" show @hidden="clientForm.status.submitted = false">Something wrong when creating client. Please try again.</t-alert>
                    </div>
                    <form v-if="!clientForm.status.submitted || Object.entries(clientForm.status.errors).length" class="p-2">
                        <fieldset>
                            <label for="name">Client Name</label>
                            <t-input id="name" name="name" v-model="clientForm.data.name"/>
                            <div v-if="Object.entries(clientForm.status.errors) && clientForm.status.errors.hasOwnProperty('name')" class="text-red-700 mb-3">
                                <div v-for="message in clientForm.status.errors.name" class="text-xs">{{ message }}</div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <label for="status">Status</label>
                            <t-select
                                placeholder="Select an option"
                                :options="['Active', 'Inactive']"
                                v-model="clientForm.data.status"
                            ></t-select>
                            <div v-if="Object.entries(clientForm.status.errors) && clientForm.status.errors.hasOwnProperty('status')" class="text-red-700 mb-3">
                                <div v-for="message in clientForm.status.errors.status" class="text-xs">{{ message }}</div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="flex content-end pt-3 text-right">
                            <t-button @click.prevent="submitCreateClient" :disabled="clientForm.status.submitting">Create</t-button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";

    export default {
        name: "Index",
        components: {AppLayout},
        data() {
            return {
                clientForm: {}
            }
        },
        created() {
            this.resetForm();
        },
        methods: {
            submitCreateClient() {
                this.clientForm.status.errors = {};
                this.clientForm.status.submitting = true;
                axios.post('/api/clients/create', this.clientForm.data).then(response => {
                    this.clientForm.data = response.data.data;
                    this.clientForm.status.result = true;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.clientForm.status.errors = error.response.data.errors;
                    }
                    this.clientForm.status.result = false;
                }).finally(() => {
                    this.clientForm.status.submitting = false;
                    this.clientForm.status.submitted = true;
                });
            },
            resetForm() {
                this.clientForm = {
                    data: {
                        name: null,
                        status: null
                    },
                    status: {
                        submitting: false,
                        submitted: false,
                        result: false,
                        errors: {},
                    }
                };
            }
        }
    }
</script>
