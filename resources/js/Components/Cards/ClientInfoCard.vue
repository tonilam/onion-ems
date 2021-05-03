<template>
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
                            :error-messages="clientForm.errors.name"
                        ></v-text-field>
                    </fieldset>
                    <fieldset>
                        <v-select label="Status"
                                  placeholder="Select an option"
                                  :items="['Active', 'Inactive']"
                                  v-model="clientForm.status"
                                  :error-messages="clientForm.errors.status"
                        ></v-select>
                    </fieldset>
                    <fieldset>
                        <v-row>
                            <v-col class="flex-grow-0">
                                <v-radio-group
                                    label="Type"
                                    v-model="clientForm.type">
                                    <v-radio
                                        label="Business"
                                        value="Business"
                                    ></v-radio>
                                    <v-radio
                                        label="Individual"
                                        value="Individual"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                            <v-col class="flex-grow-1">
                                <v-flex v-if="clientForm.type === 'Business'" class="align-center">
                                    <v-autocomplete label="Company"
                                                    v-model="selected_company"
                                                    :items="company_names"
                                                    placeholder="Select a company to be linked to this client (type to search)"
                                                    :error-messages="clientForm.errors.status"
                                    ></v-autocomplete>
                                    <v-btn small color="primary" class="ml-5"
                                           @click.prevent="show_modal = 'create-company-dialog'">
                                        New Company
                                    </v-btn>
                                </v-flex>
                                <v-flex v-if="clientForm.type === 'Individual'" class="align-center">
                                    <v-autocomplete label="Person"
                                                    v-model="selected_person"
                                                    :items="person_names"
                                                    placeholder="Select a person to be linked to this client (type to search)"
                                                    :error-messages="clientForm.errors.status"
                                    ></v-autocomplete>
                                    <v-btn small color="primary" class="ml-5"
                                           @click.prevent="show_modal = 'create-person-dialog'">
                                        New Person
                                    </v-btn>
                                </v-flex>
                            </v-col>
                        </v-row>
                    </fieldset>
                    <fieldset>
                        <div class="flex">
                            <v-btn color="secondary" :disabled="!isDirty || clientForm.processing" @click.prevent="formInit">
                                Reset
                            </v-btn>
                            <v-btn color="primary" class="ml-5" :disabled="!isDirty || clientForm.processing" @click.prevent="updateClient">
                                Save
                            </v-btn>
                            <transition name="slide-fade">
                                <v-alert v-if="clientForm.recentlySuccessful"
                                         type="success"
                                         dense
                                         outlined
                                         class="m-0 ml-5 position-absolute">
                                    Client record Saved.
                                </v-alert>
                            </transition>
                        </div>
                    </fieldset>
                </form>
            </v-card-text>
        </v-card>
        <create-company-dialog :show="show_modal === 'create-company-dialog'"
            @close="show_modal = null"
            @success="show_modal = null; preselectCompany($event)"></create-company-dialog>
        <create-person-dialog :show="show_modal === 'create-person-dialog'"
            @close="show_modal = null"
            @success="show_modal = null; preselectPerson($event)"></create-person-dialog>
    </v-container>
</template>

<script>
    import CreateCompanyDialog from '@/Components/Dialogs/CreateCompany';
    import CreatePersonDialog from '@/Components/Dialogs/CreatePerson';

    export default {
        name: "ClientInfoCard",
        components: {
            CreateCompanyDialog,
            CreatePersonDialog
        },
        props: {
            client: {type: Object, required: true}
        },
        data() {
            return {
                clientForm: this.$inertia.form({
                    _method: 'PUT',
                    name: null,
                    status: null,
                    company_id: null,
                    person_id: null,
                    type: 'Individual'
                }, {   // the following config is essential for edit form which keeps the data in the form
                    resetOnSuccess: false,
                }),
                companies: [],
                people: [],
                selected_company: null,
                selected_person: null,
                show_modal: null,
            }
        },
        computed: {
            company_names() {
                return _.map(this.companies, c => c.name);
            },
            person_names() {
                return _.map(this.people, p => p.first_name + ' ' + p.last_name);
            },
            isDirty() {
                if (this.clientForm.name !== this.client.name) return true;
                if (this.clientForm.status !== this.client.status) return true;
                if (this.clientForm.type === 'Business' && !this.client.company_id) return true;
                if (this.clientForm.type === 'Business' && !_.find(this.companies, p => {
                    return (`${p.name}` === this.selected_company) && p.id === this.client.company_id
                })) return true;
                if (this.clientForm.type === 'Individual' && !this.client.person_id) return true;
                if (this.clientForm.type === 'Individual' && !_.find(this.people, p => {
                    return (`${p.first_name} ${p.last_name}` === this.selected_person) && p.id === this.client.person_id
                })) return true;
            }
        },
        created() {
            this.$eventBus.$on('company.updated', this.refresh);
            this.$eventBus.$on('person.updated', this.refresh);
        },
        mounted() {
            this.refresh();
        },
        beforeDestroy() {
            this.$eventBus.$off('company.updated', this.refresh);
            this.$eventBus.$off('person.updated', this.refresh);
        },
        methods: {
            refresh() {
                Promise.all([
                    this.fetchCompanies(),
                    this.fetchPeople()
                ]).then(() => {
                    this.formInit();
                });
            },
            formInit() {
                this.clientForm.reset();
                this.clientForm.name = this.client.name;
                this.clientForm.status = this.client.status;
                if (this.client.company_id) {
                    let selected = _.find(this.companies, c => c.id === this.client.company_id);
                    this.selected_company = selected ? selected.name : null;
                    this.selected_person = null;
                    this.clientForm.type = 'Business';
                }
                if (this.client.person_id) {
                    let selected = _.find(this.people, p => p.id === this.client.person_id);
                    this.selected_person = selected ? selected.first_name + ' ' + selected.last_name : null;
                    this.selected_company = null;
                    this.clientForm.type = 'Individual';
                }
            },
            fetchCompanies() {
                return axios.get('/companies').then(response => {
                    this.companies = response.data.data;
                });
            },
            fetchPeople() {
                return axios.get('/people').then(response => {
                    this.people = response.data.data;
                });
            },
            preselectCompany(company_name) {
                Promise.all([
                    this.fetchCompanies()
                ]).then(() => {
                    this.selected_company = company_name;
                });
            },
            preselectPerson(person_name) {
                Promise.all([
                    this.fetchPeople()
                ]).then(() => {
                    this.selected_person = person_name;
                });
            },
            updateClient() {
                axios.put(`/clients/${this.client.id}`, {
                    ...this.clientForm.data(),
                    company_id: this.clientForm.type === 'Business' && this.selected_company ? (_.find(this.companies, c => c.name === this.selected_company)).id : null,
                    person_id: this.clientForm.type === 'Individual' && this.selected_person ? (_.find(this.people, p => `${p.first_name} ${p.last_name}` === this.selected_person)).id : null,
                }).then(() => {
                    this.clientForm.recentlySuccessful = true;
                    setTimeout(() => this.clientForm.recentlySuccessful = false, 2000);
                    this.$eventBus.$emit('client.reload');
                }).catch(error => {
                    this.clientForm.errors = error.response.data.errors;
                }).finally(() => {
                    this.clientForm.processing = false;
                });
            },
        }
    }
</script>
