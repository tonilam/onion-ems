<template>
    <v-container :fluid="false">
        <v-card>
            <v-card-text>
                <form :disabled="companyForm.processing" class="p-2">
                    <fieldset>
                        <v-row>
                            <v-col class="col-12">
                                <v-text-field
                                    label="Name"
                                    id="name"
                                    name="name"
                                    v-model="companyForm.name"
                                    :error-messages="companyForm.errors.name"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </fieldset>
                    <fieldset>
                        <div class="flex">
                            <v-btn color="primary" :disabled="!isDirty || companyForm.processing" @click.prevent="updatePerson">
                                Save
                            </v-btn>
                            <transition name="slide-fade">
                                <v-alert v-if="companyForm.recentlySuccessful"
                                         type="success"
                                         dense
                                         outlined
                                         class="m-0 ml-5 position-absolute">
                                    Company record Saved.
                                </v-alert>
                            </transition>
                        </div>
                    </fieldset>
                </form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        name: "CompanyInfoCard",
        props: {
            companyId: {type: Number, required: false, default: null},
        },
        data() {
            return {
                company: {},
                companyForm: this.$inertia.form({
                    name: null
                }, {   // the following config is essential for edit form which keeps the data in the form
                    resetOnSuccess: false,
                }),
            }
        },
        computed: {
            isDirty() {
                if (this.companyForm.name !== this.company.name) return true;
            }
        },
        watch: {
            companyId(after, before) {
                if (after !== before) {
                    this.fetchCompany();
                }
            }
        },
        created() {
            this.$eventBus.$on('person.reload', this.fetchCompany);
        },
        mounted() {
            this.fetchCompany();
        },
        beforeDestroy() {
            this.$eventBus.$off('person.reload', this.fetchCompany);
        },
        methods: {
            formInit(company) {
                this.company = company;
                this.companyForm.reset();
                this.companyForm.name = company.name;
            },
            fetchCompany() {
                axios.get(`/companies/${this.companyId}`).then(response => {
                    this.formInit(response.data)
                }).catch(() => {

                }).finally(() => {

                });
            },
            updatePerson() {
                this.companyForm.processing = true;
                axios.put(`/companies/${this.companyId}`, this.companyForm.data()).then(() => {
                    this.companyForm.recentlySuccessful = true;
                    setTimeout(() => this.companyForm.recentlySuccessful = false, 2000);
                    this.formInit(this.companyForm.data());
                    this.$eventBus.$emit('company.updated');
                }).catch(error => {
                    this.companyForm.errors = error.response.data.errors;
                }).finally(() => {
                    this.companyForm.processing = false;
                });
            },
        }
    }
</script>
