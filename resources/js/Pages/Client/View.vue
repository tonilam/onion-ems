<template>
    <app-layout :title="client.name">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
                    <div class="p-2">
                        <label>Client:</label>
                        {{ client.name }}
                    </div>
                    <div class="p-2">
                        <label>Status:</label>
                        {{ client.status }}
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    export default {
        name: "ClientView",
        props: {
            client: {type: Object, required: true}
        },
    }
</script>
