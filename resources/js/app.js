window.Vue = require('vue');

import App from './components/App.vue'
import {store} from './store/index.js'
import {router} from './router/index.js'
import {i18n} from './lang/index.js'
import VeeValidate from 'vee-validate';
import enValidationMsg from 'vee-validate/dist/locale/en';
import vnValidationMsg from 'vee-validate/dist/locale/vi';

Vue.use(VeeValidate, {
    i18n,
    dictionary: {
        en: enValidationMsg,
        vn: vnValidationMsg
    }
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
    store,
    router,
    i18n
});
