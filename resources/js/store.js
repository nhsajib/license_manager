import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({

    state: {
        access_token: null,
        user: {},
        permissions: {},
        softwareInfo: {}
    },

    mutations: {
        setAuthData(state, authData){
            state.access_token = authData.access_token;
            state.user = authData.user;
            localStorage.setItem('w3u', JSON.stringify(authData));
            window.axios.defaults.headers.common['Authorization'] = 'Bearer '+state.access_token;
        },

        clearAuthData(state){
            state.access_token = null;
            state.user = {};
            state.permissions = {};
            localStorage.removeItem('w3u');
        },

        setSoftwareInfo(state, infoData){
            state.softwareInfo = infoData;
        }
    },

    getters: {
        isAuthenticated(state){
            return state.access_token ? true : false;
        },

        getAccessToken(state){
            return state.access_token;
        },

        loggedInUser(state){
            return state.user;
        },

        domain(){
            return window.location.origin;
        }

    }

});