window.Vue = require('vue').default;
import store from "./store";
import Vue2Filters from 'vue2-filters'
import VueRouter from "vue-router";
Vue.use(VueRouter);
Vue.use(Vue2Filters)

const routes = [
    { path: '/login',
      component: require('../js/components/page/Login.vue').default,
      meta:{
        title: 'Login',
        isAuth: false
      },
      beforeEnter: (to, from, next) => {
        if(store.getters.isAuthenticated){
          next({ path: '/'})
        }
        else next()
      }
    },
    { path: '*',
      component: require('../js/components/page/404.vue').default,
      meta:{
        title: '404 - Not Found',
        isAuth: false,
      },
    },
    { path: '/',
      component: require('../js/components/page/Dashboard.vue').default,
      meta:{
        title: 'Dashboard',
        isAuth: true,
      },
    },

    { path: '/profile',
      component: require('../js/components/page/Profile.vue').default,
      meta:{
        title: 'Profile',
        isAuth: true,
      },
    },

    { path: '/software/info',
      component: require('../js/components/page/SoftwareInfo.vue').default,
      meta:{
        title: 'Software Information',
        isAuth: true,
      },
    },

    { path: '/supadm/supper/sellers',
      component: require('../js/components/page/SuperSellers.vue').default,
      meta:{
        title: 'Supper Sellers',
        isAuth: true,
      },
    },

    { path: '/supadm/sellers',
      component: require('../js/components/page/Sellers.vue').default,
      meta:{
        title: 'Sellers',
        isAuth: true,
      },
    },

    { path: '/supsell/sellers',
      component: require('../js/components/page/Sellers.vue').default,
      meta:{
        title: 'Sellers',
        isAuth: true,
      },
    },

    { path: '/license',
      component: require('../js/components/page/License.vue').default,
      meta:{
        title: 'License',
        isAuth: true,
      },
    },

    { path: '/transfer/credit',
      component: require('../js/components/page/TransferCredit.vue').default,
      meta:{
        title: 'License',
        isAuth: true,
      },
    },


    { path: '/supadm/sellers/of/sup-seller/:id',
      component: require('../js/components/page/SellerBySupSeller.vue').default,
      meta:{
        title: 'Sellers of Super Seller',
        isAuth: true,
      },
    },

    { path: '/supadm/license/of/seller/:id',
      component: require('../js/components/page/LicenseBySeller.vue').default,
      meta:{
        title: 'License of Seller',
        isAuth: true,
      },
    },

];

const router = new VueRouter({
    routes,
    mode: 'history',
});

router.beforeEach((to, from, next) => {

  document.title = to.meta.title + ' | ' + process.env.MIX_APP_NAME;

  if(to.meta.isAuth === true && store.getters.isAuthenticated === false){
    next({ path: '/login' })
  }
  next();
});

export default router;