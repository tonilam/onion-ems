<template>
    <app-layout :title="client.name">
        <v-container :fluid="false">
            <v-card>
                <v-card-text>
                    <form :disabled="clientForm.processing" class="p-2">
                        <fieldset>
                            <v-text-field
                                label="Client Name"
                                id="name"
                                name="name"
                                v-model="clientForm.name"
                                :error-messages="errors.name"
                            ></v-text-field>
                        </fieldset>
                        <fieldset>
                            <v-select label="Status"
                                placeholder="Select an option"
                                :items="['Active', 'Inactive']"
                                v-model="clientForm.status"
                                :error-messages="errors.status"
                            ></v-select>
                        </fieldset>
                        <fieldset>
                            <div class="flex content-end pt-3 text-right">
                                <v-btn color="primary" :disabled="clientForm.processing" @click.prevent="updateClient">
                                    Save
                                </v-btn>
                            </div>
                        </fieldset>
                    </form>
                </v-card-text>
            </v-card>
        </v-container>
    </app-layout>
</template>

<script>
    export default {
        name: "ClientView",
        props: {
            client: {type: Object, required: true},
            errors: {type: Object, required: false, default: () => null},
        },
        data() {
            return {
                clientForm: this.$inertia.form({
                    name: null,
                    status: null,
                }, {   // the following config is essential for edit form which keeps the data in the form
                    resetOnSuccess: false,
                }),
            }
        },
        mounted() {
            this.formInit();
        },
        methods: {
            formInit() {
                this.clientForm.name = this.client.name;
                this.clientForm.status = this.client.status;
            },
            updateClient() {
                this.clientForm.put(`/clients/${this.client.id}`, {
                    onSuccess: () => {
                    },
                    onError: () => {
                        //
                    },
                    onfinish: () => {
                    }
                })
            },
        }
    }
</script>
