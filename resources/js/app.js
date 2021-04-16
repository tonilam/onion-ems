require('./bootstrap');

require('moment');

import Vue from 'vue';

import {InertiaApp} from '@inertiajs/inertia-vue';
import {InertiaForm} from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VueTailwind from 'vue-tailwind';
import VueTailwindIcon from 'tv-icon';
import VueTailwindSetting from './Config/VueTailwind';
import AppLayout from '@/Layouts/AppLayout'

Vue.mixin({methods: {route}});
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueTailwind, VueTailwindSetting);
Vue.use(VueTailwindIcon);
Vue.component('AppLayout', AppLayout);

Vue.prototype.$eventBus = new Vue();
Vue.prototype.$fn = new Vue({
    // You can define some global functions here,
    // so that you can use $fn.xxx in any components
    methods: {
        //
    }
})

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
                resolveErrors: page => (page.props.errors || {}),
            },
        }),
}).$mount(app);
