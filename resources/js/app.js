/**
 * Load Bootstrap, Packages
 */

require('./bootstrap');
window.Vue = require('vue');

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import SWAL from 'sweetalert';

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

require('./_partials/navbar')

require('./_partials/app-menu')

require('./helpers')