<template>
    <v-container :fluid="false">
        <v-card>
            <v-card-text>
                <form :disabled="personForm.processing" class="p-2">
                    <fieldset>
                        <v-row>
                            <v-col class="col-12 col-sm-6 col-lg-4">
                                <v-text-field
                                    label="First Name"
                                    id="first_name"
                                    name="first_name"
                                    v-model="personForm.first_name"
                                    :error-messages="personForm.errors.first_name"
                                ></v-text-field>
                            </v-col>
                            <v-col class="col-12 col-sm-6 col-lg-4">
                                <v-text-field
                                    label="Middle Name"
                                    id="middle_name"
                                    name="middle_name"
                                    v-model="personForm.middle_name"
                                    :error-messages="personForm.errors.middle_name"
                                ></v-text-field>
                            </v-col>
                            <v-col class="col-12 col-sm-6 col-lg-4">
                                <v-text-field
                                    label="Last Name"
                                    id="last_name"
                                    name="last_name"
                                    v-model="personForm.last_name"
                                    :error-messages="personForm.errors.last_name"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </fieldset>
                    <fieldset>
                        <v-row>
                            <v-col>
                                <v-radio-group
                                    label="Type"
                                    v-model="personForm.gender"
                                    row>
                                    <v-radio
                                        label="Male"
                                        value="M"
                                    ></v-radio>
                                    <v-radio
                                        label="Female"
                                        value="F"
                                    ></v-radio>
                                    <v-radio
                                        label="Not Provided"
                                        value="Not Provided"
                                    ></v-radio>
                                    <v-radio
                                        label="Unknown"
                                        value="Unknown"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                        </v-row>
                    </fieldset>
                    <fieldset>
                        <v-row>
                            <v-col class="col-12 col-sm-6 col-lg-4">
                                <v-menu ref="menu"
                                    v-model="dob_picker"
                                    :close-on-content-click="false"
                                    :return-value.sync="personForm.dob"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="personForm.dob"
                                            label="Date of Birth"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            clearable
                                            v-bind="attrs"
                                            v-on="on"
                                            @click:clear="date = null"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="personForm.dob"
                                        no-title
                                        scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text
                                            color="primary"
                                            @click="dob_picker = false">
                                            Cancel
                                        </v-btn>
                                        <v-btn text
                                            color="primary"
                                            @click="$refs.menu.save(personForm.dob)">
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </fieldset>
                    <fieldset>
                        <div class="flex">
                            <v-btn color="primary" :disabled="!isDirty || personForm.processing" @click.prevent="updatePerson">
                                Save
                            </v-btn>
                            <transition name="slide-fade">
                                <v-alert v-if="personForm.recentlySuccessful"
                                         type="success"
                                         dense
                                         outlined
                                         class="m-0 ml-5 position-absolute">
                                    Person record Saved.
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
        name: "PersonInfoCard",
        props: {
            personId: {type: Number, required: false, default: null},
        },
        data() {
            return {
                person: {},
                personForm: this.$inertia.form({
                    first_name: null,
                    middle_name: null,
                    last_name: null,
                    gender: null,
                    dob: null,
                }, {   // the following config is essential for edit form which keeps the data in the form
                    resetOnSuccess: false,
                }),
                dob_picker: false,
            }
        },
        computed: {
            isDirty() {
                if (this.personForm.first_name !== this.person.first_name) return true;
                if (this.personForm.middle_name !== this.person.middle_name) return true;
                if (this.personForm.last_name !== this.person.last_name) return true;
                if (this.personForm.gender !== this.person.gender) return true;
                if (this.personForm.dob !== this.person.dob) return true;
            }
        },
        watch: {
            personId(after, before) {
                if (after !== before) {
                    this.fetchPerson();
                }
            }
        },
        created() {
            this.$eventBus.$on('person.reload', this.fetchPerson);
        },
        mounted() {
            this.fetchPerson();
        },
        beforeDestroy() {
            this.$eventBus.$off('person.reload', this.fetchPerson);
        },
        methods: {
            formInit(person) {
                this.person = person;
                this.personForm.reset();
                this.personForm.first_name = person.first_name;
                this.personForm.middle_name = person.middle_name;
                this.personForm.last_name = person.last_name;
                this.personForm.gender = person.gender;
                this.personForm.dob = person.dob;
            },
            fetchPerson() {
                axios.get(`/people/${this.personId}`).then(response => {
                    this.formInit(response.data)
                }).catch(() => {

                }).finally(() => {

                });
            },
            updatePerson() {
                this.personForm.processing = true;
                axios.put(`/people/${this.personId}`, this.personForm.data()).then(() => {
                    this.personForm.recentlySuccessful = true;
                    setTimeout(() => this.personForm.recentlySuccessful = false, 2000);
                    this.formInit(this.personForm.data());
                    this.$eventBus.$emit('person.updated');
                }).catch(error => {
                    this.personForm.errors = error.response.data.errors;
                }).finally(() => {
                    this.personForm.processing = false;
                });
            },
        }
    }
</script>
