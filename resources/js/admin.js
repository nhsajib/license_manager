require('./bootstrap');
import store from './store';
import router from './router';
require('./browserRefreshAuth');
import Form from 'vform';
import moment from 'moment';
import { Notify } from 'notiflix/build/notiflix-notify-aio';
import { Confirm } from 'notiflix/build/notiflix-confirm-aio';
import { Block } from 'notiflix/build/notiflix-block-aio';

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect);

window.Form = Form;
window.Notify = Notify;
window.Confirm = Confirm;
window.Block = Block;

//Date format for template
Vue.filter('Date', function(value) {
  if (value) {
      return moment(String(value)).format('ll')
  }
});

Vue.filter('DateTime', function(value) {
    if (value) {
        return moment(String(value)).format('MMM Do YYYY, h:mm a')
    }
});

Vue.filter('StringToTime', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('index-component', require('../js/components/index.vue').default);
Vue.component('nav-bar', require('../js/components/partials/NavBar.vue').default);
Vue.component('footerx', require('../js/components/partials/Footer.vue').default);
Vue.component('sidebar', require('../js/components/partials/SideBar.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
    created(){
        window.axios.defaults.headers.common['Authorization'] = 'Bearer '+this.$store.getters.getAccessToken;
        window.axios.interceptors.response.use(
            response => response,
            error => {
                if(error.response.status === 401){
                    this.$store.commit('clearAuthData');
                    this.$router.push('/login')
                }

                return Promise.reject(error);
            }
        );
    },
});
