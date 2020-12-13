<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clients
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <t-alert variant="warning" class="flex" show>
                        <IconInfo primary="text-yellow-300" secondary="text-yellow-300" class="w-5 h-5 inline-block" />
                        Under construction
                    </t-alert>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";

    export default {
        name: "Index",
        components: {AppLayout}
    }
</script>

<style scoped>

</style>
