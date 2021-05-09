<template>
    <v-dialog :value="show"
        persistent
        width="500">
        <v-card>
            <v-card-title>Create Contact</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col class="col-4">
                            <v-select label="Type"
                                placeholder="Type of contact"
                                :items="['Phone', 'Fax', 'Email', 'Address']"
                                v-model="createForm.type"
                                name="type"
                                :error-messages="createForm.errors.type"
                            ></v-select>
                        </v-col>
                        <v-col class="col-8">
                            <v-text-field label="Label"
                                          v-model="createForm.label"
                                          name="label"
                                          :error-messages="createForm.errors.label"></v-text-field>
                        </v-col>
                        <v-col class="col-12">
                            <v-text-field label="Content"
                                v-model="createForm.content"
                                name="content"
                                :error-messages="createForm.errors.content"></v-text-field>
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
        name: 'CreateContactDialog',
        props: {
            show: {type: Boolean, required: false, default: false},
            companyId: {type: Number, required: false, default: null},
            personId: {type: Number, required: false, default: null},
        },
        data() {
            return {
                createForm: this.$inertia.form({
                    type: null,
                    content: null,
                    label: null,
                })
            }
        },
        methods: {
            cancel() {
                this.createForm.reset();
                this.$emit('close');
            },
            submitForm() {
                axios.post('/contacts', {
                    ...this.createForm.data(),
                    company_id: this.companyId,
                    person_id: this.personId
                }).then(() => {
                    this.$emit('success');
                    this.cancel();
                }).catch(errors => {
                    this.createForm.errors = errors.response.data;
                }).finally(() => {
                    //
                });
            }
        }
    }
</script>
