<template>
    <div class="">
      <Header></Header>

      <div class="container">
        <div class="row mtop10per mbot150px">

          <div class="col-md-4"></div>
          <div class="col-md-4">
                <h2 class="text-center">Active your account</h2>
                <div class="clearfix"><br/></div>
                  <form @submit.prevent="verify">
                      <div class="form-group">
                          <label for="key">Activation Key</label>
                          <input type="text" class="form-control h40 br0" id="key" v-model="key" required>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-dark btn-block h40 br0" :disabled="btnLoading">
                            <span v-if="!btnLoading">Active</span>
                            <span v-if="btnLoading"><div class="loader sx-loader"></div></span>
                          </button>
                      </div>
                  </form>
              </div>

        </div>
      </div>


           



      <Footer></Footer>
    </div>
</template>

<script>
  import Header from '../layouts/Header.vue';
  import Footer from '../layouts/Footer.vue';

  export default {
    name: 'Forgot',
    components: {
      Header,
      Footer
    },
    mounted() {},
    data() {
        return {
          key: '',
          btnLoading: false,

          csrfToken: '',
          accessToken: '',
        }
    },
    computed: {},
    created() {

    },
    methods: {
      
      verify() {
         this.btnLoading = true;
          axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let formData = new FormData();
          formData.append('key', this.key);
          axios.post('/api/v1/verify', formData, config)
          .then(res => {
              this.btnLoading = false;
              if(res.data.statusCode == 200) {
                  localStorage.setItem('accessToken', res.data.data.accessToken);
                  localStorage.setItem('username', res.data.data.username);
                  localStorage.setItem('is_author', res.data.data.is_author);
                  localStorage.setItem('is_admin', res.data.data.is_admin);
                  this.$router.push({ name: 'home' })
              } else {
                this.$noty.error("Opps, <br/>"+res.data.errors);
              }
          })
          .catch(err => {
              this.btnLoading = false;
              this.$noty.error("Opps, <br/>Something went wrong");
          });
      }, 

    }
  }
</script>

<style scoped="">
    .loader {
        position: absolute;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 3px solid #f3f3f3;
        border-top: 3px solid #686767;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 0.7s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .sx-loader { width:30px; height:30px; border:2px solid #f3f3f3; border-top:2px solid transparent; position:relative; left: 45%; margin-top: -1px }
    .mtop10per { margin-top: 10% }
    .mbot150px { margin-bottom: 150px }
    .w100per { width: 100% }
    .f14 { font-size: 14px }
    .h38 { height: 38px } 
    .br0 { border-radius: 0 }
    .h40 { height: 40px; outline: none !important }
    label { font-weight: 800 }
    .fw800 { font-weight: 800 }
</style>
