require('./bootstrap');

require('moment');

import Vue from 'vue';

import {InertiaApp} from '@inertiajs/inertia-vue';
import {InertiaForm} from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VueTailwind from 'vue-tailwind';

import {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDropdown,
    TRichSelect,
    TPagination,
    TTag,
    TRadioGroup,
    TCheckboxGroup,
    TTable,
    TDatepicker,
    TToggle,
    TDialog,
} from 'vue-tailwind/dist/components';

const settings = {
    // Use the following syntax
    // {component-name}: {
    //   component: {importedComponentObject},
    //   props: {
    //     {propToOverride}: {newDefaultValue}
    //     {propToOverride2}: {newDefaultValue2}
    //   }
    // }
    't-input': {
        component: TInput,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
            // ...More settings
        }
    },
    't-textarea': {
        component: TTextarea,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
            // ...More settings
        }
    },
    't-dropdown': {
        component: TDropdown,
        props: {
            classes: {}
            // ...More settings
        }
    },
    't-button': {
        component: TButton,
        props: {
            classes: {}
            // ...More settings
        }
    },
    // ...Rest of the components
}

Vue.mixin({methods: {route}});
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueTailwind, settings);

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
