/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as VueRouter from 'vue-router';
import { routes } from './router';

const vuetify = createVuetify({
    components,
    directives,
})
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
import axios from 'axios';
axios.interceptors.response.use((response) => response, (error) => {
    if(error.response.status === 401)
    {
         window.location.replace("/login");
    }
    return Promise.reject(error);
});


const app = createApp({});
 app.config.globalProperties.auth= {};

await axios.get('/api/auth').then(response => {
    app.config.globalProperties.auth = response.data
    if(window.location.pathname === '/home' && !response.data.permissions.analytics_graphics || window.location.pathname === '/home' && !response.data.permissions.analytics_pie)
    {
        window.location = '/orders';
    }
    if(window.location.pathname === '/orders' &&  !response.data.permissions.orders_view)
    {
        window.location = '/users';
    }
    if(window.location.pathname === '/products' &&  !response.data.permissions.products_view)
    {
        window.location = '/site';
    }
    if(window.location.pathname === '/settings' &&  !response.data.permissions.settings_view)
    {
        window.location = '/home';
    }
})


import ExampleComponent from './components/ExampleComponent.vue';
import HomeComponent from './components/HomeComponent.vue';
import LoginComponent from "./components/LoginComponent.vue";
import AnalyticsComponent from "./components/AnalyticsComponent.vue";

import NavigationComponent from "./components/NavigationComponent.vue";
app.component('example-component', ExampleComponent);
app.component('home-component', HomeComponent);
app.component('login-component', LoginComponent);
app.component('analytics', AnalyticsComponent);

app.component('navigation-component', NavigationComponent);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/'),
    routes
});


await app.use(vuetify).use(router).mount('#app');
