
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

window.toastr = require('toastr');
window.Echo = require('laravel-echo');
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'a5fe158fb56fbce65308',
    cluster: 'us2',
    encrypted: true
});

import VueRouter from 'vue-router'
import routes from './routes';
Vue.use(VueRouter);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('fila', require('./components/Fila.vue'));
Vue.component('notification', require('./components/Notification.vue'));
Vue.component('producao-tasks', require('./components/Producao.vue'));
Vue.component('pedido', require('./components/Pedido.vue'));
Vue.component('loading', require('vue-full-loading'));

Vue.component('produto-nav', require('./components/produto/ProdutoNav'));
Vue.component('estoque-nav', require('./components/estoque/EstoqueNav'));

import vSelect from 'vue-select';
Vue.component('v-select', vSelect);

const router = new VueRouter({
    hashbang: false,
    mode: 'history',
    routes: routes
});

window.router = router;

const app = new Vue({
    el: '#app',
    router: router,
});
