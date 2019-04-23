require('./bootstrap');

window.Vue = require('vue');

import App from './components/App.vue'
import {store} from './store/index.js'
import {router} from './router/index.js'

const app = new Vue({
    el: '#app',
    render: h => h(App),
    store,
    router
});
