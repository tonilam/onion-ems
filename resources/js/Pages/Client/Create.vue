<template>
    <app-layout title="Create Client">
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
                            >
                            </v-select>
                        </fieldset>
                        <fieldset>
                            <div class="flex content-end pt-3 text-right">
                                <v-btn color="primary" :disabled="clientForm.processing" @click.prevent="createClient">
                                    Create
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
        name: "ClientCreate",
        props: {
            errors: {type: Object, required: false, default: () => null},
        },
        data() {
            return {
                clientForm: this.$inertia.form({
                    name: null,
                    status: null,
                }),
            }
        },
        mounted() {
            this.clientForm.reset();
        },
        methods: {
            createClient() {
                this.clientForm.post('/clients', {
                    onSuccess: () => {
                        //
                    },
                    onError: () => {
                        //
                    },
                    onfinish: () => {
                        //
                    }
                })
            },
        }
    }
</script>
