<template>
    <div class="">
      <Header></Header>

      <div class="container">
        <div class="row mtop10per mbot50px">


          <div class="col-md-8">

              <div class="card">
                <div class="card-header bg-default"> Contact us </div>
                <div class="card-body">
                    <form @submit.prevent="contact()">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" v-model="row.name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" v-model="row.email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="6" v-model="row.message" required></textarea>
                        </div>
                        <div class="mx-auto">
                          <button type="submit" class="btn btn-primary text-right h35" :disabled="btnLoading">
                            <span v-if="!btnLoading">Submit</span>
                            <span v-if="btnLoading"><div class="loader sx-loader"></div></span>
                          </button>
                        </div>
                    </form>
                </div>
              </div>

          </div>


    
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-default"> Address</div>
                    <div class="card-body">
                        <p>3 rue des Champs Elysées</p>
                        <p>75008 PARIS, France</p>
                        <p>Email : email@example.com</p>
                        <p>Tel. +33 12 56 11 51 84</p>
                    </div>
                </div>

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
    name: 'Posts',
    components: {
      Header,
      Footer
    },
    mounted() {},
    data() {
        return {
          row: {
            name: '',
            email: '',
            message: '',
          },
          btnLoading: false,
          something_went_wrong: false,

          csrfToken: '',
          accessToken: '',
        }
    },
    computed: {},
    created() {

      if(localStorage.getItem('accessToken')) {
        this.accessToken = localStorage.getItem('accessToken');
      }

    },
    methods: {
      
      contact() {
         this.btnLoading = true;
          axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let formData = new FormData();
          formData.append('name', this.row.name);
          formData.append('email', this.row.email);
          formData.append('message', this.row.message);
          formData.append('accessToken', this.accessToken);
          axios.post('/api/v1/contact', formData, config)
          .then(res => {
              this.btnLoading = false;
              this.row.message = '';
              if(res.data.statusCode == 201) {
                this.$noty.info(this.$i18n.messages[this.$i18n.locale].app.success_msg);
              } else {
                this.$noty.error('Opps<br/>'+res.data.err);
              }
          })
          .catch(err => {
              this.btnLoading = false;
              this.something_went_wrong = true;
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
    .sx-loader { width:20px;height:20px;border:2px solid #f3f3f3;border-top:2px solid transparent;position:relative;left:5%; margin-top: -5px}
    .mtop10per { margin-top: 10% }
    .mbot50px { margin-bottom: 50px }
    .mH400 { min-height: 400px }
    .w100per { width: 100% }
    .br20px { border-radius: 20px }
    .f13 { font-size: 13px }
    .h38 { height: 38px } 
    .br0 { border-radius: 0 }
    .h35 { height: 35px }
</style>
