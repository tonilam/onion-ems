<template>
    <div class="inline-flex items-center">
        <t-dropdown v-for="(navItem, navIdx) in list" :key="`nav_${navIdx}`" :text="navItem.title" class="relative px-4 py-5 mt-2
            border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
            hover:text-gray-700 hover:border-gray-300
            focus:outline-none focus:ring focus:border-blue-300 focus:text-gray-700 focus:border-gray-300
            transition duration-150 ease-in-out">
            <div class="absolute object-left mt-5 shadow-xs bg-green-300 text-blue-900" style="left: -0.5rem;">
                <t-button v-for="(subItem, subIdx) in navItem.list" :key="`nav_${navIdx}_sub_${subIdx}`"
                          class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out
                                 hover:bg-green-100
                                 focus:outline-none focus:bg-gray-100"
                          role="menuitem" href="#">
                    <span class="whitespace-nowrap">{{ subItem.title }}</span>
                </t-button>
            </div>
        </t-dropdown>
    </div>
</template>

<script>
    export default {
        name: "UserNavigation",
        computed: {
            list() {
                return require("@/Constants/menu.js")
            }
        }
    }
</script>
