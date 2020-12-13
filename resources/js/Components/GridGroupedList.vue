<template>
    <div data-component="GridGroupedList">
        <div class="bg-white border-b border-gray-200 p-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div v-for="(group, index) in list" :key="`group_${index}`"
                     class="bg-gradient-to-r from-teal-100 to-blue-100 rounded-md p-3">
                    <b>
                        <slot name="title" v-bind:group="group">
                            {{ group.title }}
                        </slot>
                    </b>
                    <ul class="list-inside bg-rose-200">
                        <li v-for="(item, item_idx) in group.list" :key="`group_${index}_item_${item_idx}`"
                            class="text-sm">{{ item.title }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GridGroupedList",
        props: {
            list: {type: Array, required: true}
        }
    }
</script>
