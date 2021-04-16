<template>
    <app-layout title="Create Client">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg in">
                    <form :disabled="clientForm.processing" class="p-2">
                        <fieldset>
                            <label for="name">Client Name</label>
                            <t-input id="name" name="name" v-model="clientForm.name"/>
                            <div v-if="errors.name" class="text-red-700 mb-3">
                                {{ errors.name }}
                            </div>
                        </fieldset>
                        <fieldset>
                            <label for="status">Status</label>
                            <t-select
                                placeholder="Select an option"
                                :options="['Active', 'Inactive']"
                                v-model="clientForm.status"
                            ></t-select>
                            <div v-if="errors.status" class="text-red-700 mb-3">
                                {{ errors.status }}
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="flex content-end pt-3 text-right">
                                <t-button @click.prevent="submitCreateClient" :disabled="clientForm.processing">Create</t-button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    export default {
        name: "Index",
        props: {
            errors: Object,
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
            submitCreateClient() {
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
