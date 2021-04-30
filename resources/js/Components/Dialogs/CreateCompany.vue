<template>
    <v-dialog :value="show"
        persistent
        width="500">
        <v-card>
            <v-card-title>Create Company</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col>
                            <v-text-field label="Company Name"
                                v-model="createForm.name"
                                name="name"
                                :error-messages="createForm.errors.name"></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="light"
                    @click="cancel">
                    Cancel
                </v-btn>
                <v-btn
                    color="primary"
                    :disabled="createForm.processing"
                    @click="submitForm">
                    Add
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: 'CreateCompanyDialog',
        props: {
            show: {type: Boolean, required: false, default: false},
        },
        data() {
            return {
                createForm: this.$inertia.form({
                    name: null,
                })
            }
        },
        methods: {
            cancel() {
                this.createForm.reset();
                this.$emit('close');
            },
            submitForm() {
                this.createForm.post('/companies', {
                    onSuccess: () => {
                        this.$emit('success', this.createForm.name);
                        this.createForm.reset();
                    },
                    onError: () => {
                        //
                    },
                    onfinish: () => {
                        //
                    }
                });
            }
        }
    }
</script>
