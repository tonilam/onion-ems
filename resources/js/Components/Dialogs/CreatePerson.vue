<template>
    <v-dialog :value="show"
        persistent
        width="500">
        <v-card>
            <v-card-title>Create Person</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col>
                            <v-text-field label="First Name"
                                v-model="createForm.first_name"
                                name="first_name"
                                :error-messages="createForm.errors.first_name"></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field label="Last Name"
                                          v-model="createForm.last_name"
                                          name="last_name"
                                          :error-messages="createForm.errors.last_name"></v-text-field>
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
                    first_name: null,
                    last_name: null,
                })
            }
        },
        methods: {
            cancel() {
                this.createForm.reset();
                this.$emit('close');
            },
            submitForm() {
                axios.post('/people', this.createForm.data()).then(() => {
                    this.$emit('success', this.createForm.first_name + ' ' + this.createForm.last_name);
                    this.createForm.reset();
                }).catch(error => {
                    this.createForm.errors = error.response.data.errors;
                }).finally(() => {
                    //
                });
            }
        }
    }
</script>
