<template>

  <div class="content-wrapper d-flex align-items-center auth px-0" id="login-page">
    <div class="row w-100 mx-0">
      <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
          <div class="brand-logo text-center">
            <img :src="$store.getters.domain+'/images/logo.png'" width="250px" class="mr-2" alt="logo"/>
          </div>
          <br>
          <br>
          <h6 class="font-weight-light text-center">Enter password to continue</h6>
          <form class="pt-3" @submit.prevent="login">
            <div class="form-group">
              <input type="text" v-model="loginData.email" class="form-control form-control-lg" id="email" placeholder="User Id" required>
            </div>
            <div class="form-group">
              <input type="password" v-model="loginData.password" class="form-control form-control-lg" id="password" placeholder="Password" required>
            </div>
            <div v-if="error" class="error-message">
              <p class="text-danger text-center font-weight-bold">{{ error }}</p>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-block btn-primary font-weight-medium auth-form-btn">Login</button>
            </div>
            <div class="my-2 d-flex justify-content-end align-items-center">
              <!-- <a href="#" class="text-black">Forgot password?</a> -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->

</template>
<script>
window.bn;
// import bn from '../../locale/bn';

export default {
  data(){
    return {
      translate: {},
      loginData: {
        email: '',
        password: '',
      },

      error: '',

      appInfo: {
        appName: '',
        appTitle: '',
      }
    }
  },

  methods: {

    login(){

      axios.post('/api/user/login', this.loginData)
        .then(res=>{
          this.$store.commit('setAuthData', res.data);
          this.$router.push('/')
          location.reload();
        })
        .catch(e=>{
          this.error = e.response.data.message;
          console.log(e);
        })
    }
  },
  mounted(){
    this.appInfo.appName = process.env.MIX_APP_NAME;
    this.appInfo.appTitle = process.env.MIX_APP_TITLE
  }
}
</script>
<style scoped>
    #login-page{
        position: fixed;
        z-index: 2500;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
    }
    .error-message{
      padding: 0.5rem;
      background: #ff474730;
      border-radius: 4px;
      border-left: 2px solid #ff4747;
    }
    .error-message p {
      margin-bottom: 0;
    }
</style>