import {TAlert, TButton, TDropdown, TInput, TTable, TTextarea} from "vue-tailwind/dist/components";

// VueTailwind documentation:
// https://www.vue-tailwind.com/docs/installation

const settings = {
    // Use the following syntax
    // {component-name}: {
    //   component: {importedComponentObject},
    //   props: {
    //     {propToOverride}: {newDefaultValue}
    //     {propToOverride2}: {newDefaultValue2}
    //   }
    // }
    't-alert': {
        component: TAlert,
        props: {
            fixedClasses: {
                wrapper: 'relative flex items-center p-4 border-l-4  rounded shadow-sm',
                body: 'flex-grow',
                close: 'absolute relative flex items-center justify-center ml-4 flex-shrink-0 w-6 h-6 transition duration-100 ease-in-out rounded focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50',
                closeIcon: 'fill-current h-4 w-4'
            },
            classes: {
                wrapper: 'bg-blue-50 border-blue-500',
                body: 'text-blue-700',
                close: 'text-blue-500 hover:bg-blue-200'
            },
            variants: {
                danger: {
                    wrapper: 'bg-red-50 border-red-500',
                    body: 'text-red-700',
                    close: 'text-red-500 hover:bg-red-200'
                },
                warning: {
                    wrapper: 'bg-yellow-50 border-yellow-500',
                    body: 'text-yellow-700',
                    close: 'text-yellow-500 hover:bg-yellow-200'
                },
                info: {
                    wrapper: 'bg-blue-50 border-blue-500',
                    body: 'text-blue-700',
                    close: 'text-blue-500 hover:bg-blue-200'
                },
                secondary: {
                    wrapper: 'bg-gray-50 border-gray-500',
                    body: 'text-gray-500',
                    close: 'text-gray-500 hover:bg-gray-200'
                },
                primary: {
                    wrapper: 'bg-gray-50 border-black',
                    body: 'text-black',
                    close: 'text-black hover:bg-gray-200'
                },
                success: {
                    wrapper: 'bg-green-50 border-green-500',
                    body: 'text-green-700',
                    close: 'text-green-500 hover:bg-green-200'
                }
            }
        }
    },
    't-button': {
        component: TButton,
        props: {
            fixedClasses: 'block transition duration-100 ease-in-out' +
                ' focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50' +
                ' disabled:opacity-50 disabled:cursor-not-allowed' +
                ' text-white text-center border border-transparent shadow-sm',
            classes: ' px-4 py-2 rounded bg-blue-500 hover:bg-blue-600',
            variants: {
                danger: 'px-4 py-2 rounded bg-red-500 hover:bg-red-600',
                danger_action: 'ml-1 px-2 py-1 rounded bg-red-500 hover:bg-red-600',
                warning: 'px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-500',
                warning_action: 'ml-1 px-2 py-1 rounded bg-yellow-400 hover:bg-yellow-500',
                success: 'px-4 py-2 rounded bg-green-500 hover:bg-green-600',
                success_action: 'ml-1 px-2 py-1 rounded bg-green-500 hover:bg-green-600',
                secondary: 'px-4 py-2 rounded bg-gray-500 hover:bg-gray-600',
                secondary_action: 'ml-1 px-2 py-1 rounded bg-gray-500 hover:bg-gray-600',
                primary: 'px-4 py-2 rounded bg-blue-500 hover:bg-blue-600',
                primary_action: 'ml-1 px-2 py-1 rounded bg-blue-500 hover:bg-blue-600',
            }
        }
    },
    't-dropdown': {
        component: TDropdown,
        props: {
            classes: {}
            // ...More settings
        }
    },
    't-input': {
        component: TInput,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
            // ...More settings
        }
    },
    't-table' :{
        component: TTable,
        props: {
            classes: {
                table: 'min-w-full divide-y divide-gray-100 shadow-sm border-gray-200 border font-table',
                thead: '',
                theadTr: '',
                theadTh: 'px-3 py-2 font-semibold text-left bg-gray-100 border-b',
                tbody: 'bg-white divide-y divide-gray-100',
                tr: '',
                td: 'px-3 py-2 whitespace-no-wrap',
                tfoot: '',
                tfootTr: '',
                tfootTd: ''
            },
            variants: {
                thin: {
                    td: 'p-1 whitespace-no-wrap text-sm',
                    theadTh: 'p-1 font-semibold text-left bg-gray-100 border-b text-sm'
                }
            }
        }
    },
    't-textarea': {
        component: TTextarea,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
            // ...More settings
        }
    },
    // ...Rest of the components
};

export default settings;
