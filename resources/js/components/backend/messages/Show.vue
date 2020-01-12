<template>
    <div class="">

    <body class="sidebar-dark">
      <div class="main-wrapper">

         <Navigation></Navigation>
          <div class="page-wrapper">
          <Header></Header>

            <div class="page-content">
              <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><router-link :to="{ name: 'dashboard' }">{{ $t('app.dashboard') }}</router-link></li>
                  <li class="breadcrumb-item active" aria-current="page">SHOW</li>
                </ol>
              </nav>

              <div class="row" v-if="pgLoading">
                <div class="loader"></div>
              </div>

              <div class="row" v-if="!pgLoading" style="display: unset">
                <div v-if="something_went_wrong" class="something_went_wrong">
                    <h5>{{ $t('app.something_went_wrong') }}</h5>
                    <button class="btn btn-primary"style="border-radius: 20px" @click="fetchData()">
                      <i class="fa fa-refresh f14"></i> {{ $t('app.try_again') }}
                    </button>
                </div>
              </div>

            <form>
              <div class="row" v-if="!pgLoading && !something_went_wrong">

                <div class="col-md-8 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body dir-ltr">
                       <h6 class="card-title">CONTENT</h6>
                      <vue-simplemde v-model="row.message" ref="markdownEditor" readonly=""/>
                    </div>
                  </div>
                </div>

                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                          <div class="form-group">
                            <label for="txt2">NAME</label>
                            <input type="text" class="form-control" id="txt2" v-model="row.name" readonly="">
                          </div>
                          <div class="form-group">
                            <label for="txt3">EMAIL</label>
                            <input type="text" class="form-control" id="txt3" v-model="row.email" readonly="">
                          </div>
                          <div class="form-group">
                            <label for="txt4">CREATED AT</label>
                            <input type="text" class="form-control" id="txt4" v-model="row.created_at" readonly="">
                          </div>
                      </div>
                    </div>
                  </div>

                  

                <div class="col-md-12 grid-margin stretch-card">
                  <div class="form-group">
                      <button type="button" class="btn btn-danger" @click="$router.go(-1)">{{ $t('app.cancel') }}</button>
                  </div>
                </div>

              </div>
             </form>

            </div>
          <Footer></Footer>
          </div>
        </div>
      </body>

    </div>
</template>

<script>
  import Navigation from '../layouts/Navigation.vue';
  import Header from '../layouts/Header.vue';
  import Footer from '../layouts/Footer.vue';
  import VueSimplemde from 'vue-simplemde';

  export default {
    name: 'App',
    components: {
      Navigation,
      Header,
      Footer,
      VueSimplemde,
    },
    mounted() {},
    data() {
        return {
          row: {
            name: '',
            email: '',
            message: '',
            created_at: '',
          },
          pgLoading: false,
          btnLoading: false,
          something_went_wrong: false,
          csrfToken: '',
          accessToken: '',
        }
    },
    computed: {},
    created() {
      if(localStorage.getItem('csrfToken')) {
        this.csrfToken = localStorage.getItem('csrfToken');
      }
      if(localStorage.getItem('accessToken')) {
        this.accessToken = localStorage.getItem('accessToken');
      }
      this.fetchData();
    },
    methods: {

        fetchData() {
          this.pgLoading = true;
          this.something_went_wrong = false;
          axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let formData = new FormData();
          formData.append('id', this.$route.params.id);
          formData.append('accessToken', this.accessToken);
          axios.post('/api/v1/dashboard/message/show', formData, config)
            .then(res => {
              this.row.name = res.data.data.name;
              this.row.email = res.data.data.email;
              this.row.created_at = res.data.data.created_at;
              this.row.message = res.data.data.message;
              this.pgLoading = false;
            })
            .catch(err => {
              this.pgLoading = false;
              this.something_went_wrong = true;
          });
        },

    },
  }
</script>


<style scoped="">
    .loader {
        position: absolute;
        left: 56.5%;
        transform: translate(-50%, -50%);
        border: 3px solid #f3f3f3;
        border-top: 3px solid #686767;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .image { width: 100%; height: 185px; margin-bottom: 5px; border-color: transparent }
    .sm-loader { width:40px;height:40px;border:2px solid #f3f3f3;border-top:2px solid #000;position:relative;left:40%;margin-top: 10px }
    .sx-loader { width:20px;height:20px;border:2px solid #f3f3f3;border-top:2px solid transparent;position:relative;left:5%; margin-top: -4px}
</style>
