require('./bootstrap');

import Vue from 'vue';
import Axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import VueFormWizard from 'vue-form-wizard'
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import ContratSimple from 'components/forms/ContratSimpleComponent.vue';

Vue.use(VueFormWizard)
Vue.use(VueSweetalert2);

new Vue({
    el: '#app',
    components: {
        ContratSimple
    }
})