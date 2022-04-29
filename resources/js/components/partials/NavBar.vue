<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/"><img :src="$store.getters.domain+'/images/logo.png'" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="/"><img :src="$store.getters.domain+'/images/logo-mini.png'" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle logout" href="#" data-toggle="dropdown" id="profileDropdown">
              <span class="font-weight-bold">{{ $store.state.user.name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <router-link to="/profile" class="dropdown-item">
                <i class="ti-user text-primary"></i>
                Profile
              </router-link>
              <a class="dropdown-item" @click="logOut">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
</template>
<script>
export default {
  data(){
    return {

    }
  },

  methods: {
    async logOut(){
      await axios.post('/api/user/logout')
            .then(res=>{
              this.$store.commit('clearAuthData');
              this.$router.push('/login')
            })
            .catch(e=>{
              console.log(e);
            })
    }
  },
  mounted(){
    // console.log(this.$store.state);
  }
}
</script>