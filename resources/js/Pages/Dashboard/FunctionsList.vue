<template>
    <grid-grouped-list :list="list">
        <template slot="title" slot-scope="props">{{ props.group.title }} Management</template>
    </grid-grouped-list>
</template>

<script>
    import GridGroupedList from "@/Components/GridGroupedList";

    export default {
        name: "FunctionsList",
        components: {GridGroupedList},
        data() {
            return {}
        },
        computed: {
            list() {
                return require("@/Constants/menu.js")
            }
        }
    }
</script>
