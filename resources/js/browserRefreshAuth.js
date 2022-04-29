import store from './store';

let authUser = localStorage.getItem('w3u');
if(authUser){
    let authUserd = JSON.parse(authUser);
    store.commit('setAuthData', authUserd);
}