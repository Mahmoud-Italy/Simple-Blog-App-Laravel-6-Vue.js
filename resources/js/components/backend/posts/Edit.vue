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
                  <li class="breadcrumb-item active" aria-current="page">{{ $t('app.update') }}</li>
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

            <form @submit.prevent="update" enctype="multipart/form-data">
              <div class="row" v-if="!pgLoading && !something_went_wrong">

                  <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                          <div class="form-group">
                            <label for="txt1">TITLE</label>
                            <input type="text" class="form-control" id="txt1" v-model="row.title" required="">
                          </div>
                          <div class="form-group">
                            <label for="txt2">TAGS</label>
                            <tags-input element-id="tags" id="txt2" v-model="row.tags" @tag-added="onTagAdded" @tag-removed="onTagRemoved" placeholder="Add a tag"></tags-input>
                          </div>
                          <div class="form-group">
                            <label for="txt3">STATUS</label>
                            <select class="form-control" id="txt3" v-model="row.status" required="">
                                <option value="1">ACTIVE</option>
                                <option value="0">DEACTIVE</option>
                            </select>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <label for="txt5">{{ $t('meetings.image') }}</label>
                        <img :src="(row.preview) ? row.preview : row.image" class="image">
                        <input type="file" ref="myDropify" v-on:change="onImageChange"/>
                      </div>
                    </div>
                  </div>
              
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body dir-ltr">
                       <h6 class="card-title">CONTENT</h6>
                      <vue-simplemde v-model="row.content" ref="markdownEditor" />
                    </div>
                  </div>
                </div>


                <div class="col-md-12 grid-margin stretch-card">
                  <div class="form-group">
                      <button class="btn btn-primary" :disabled="btnLoading">
                        <span v-if="!btnLoading">{{ $t('app.submit') }}</span>
                        <div class="loader sx-loader" v-if="btnLoading"></div>
                      </button>
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
  import VoerroTagsInput from '@voerro/vue-tagsinput';

  export default {
    name: 'App',
    components: {
      Navigation,
      Header,
      Footer,
      VueSimplemde,
      VoerroTagsInput
    },
    mounted() {},
    data() {
        return {
          row: {
            preview: '',
            image: '',
            title: '',
            tags: [],
            tagsSelected: [],
            status: 1,
            content: '',
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
          axios.post('/api/v1/dashboard/post/edit', formData, config)
            .then(res => {
              this.row.preview = res.data.data.image;
              this.row.title = res.data.data.title;
              this.row.content = res.data.data.content;
              this.row.status = res.data.data.status;
              this.row.tags = res.data.data.tags;
              this.pgLoading = false;
            })
            .catch(err => {
              this.pgLoading = false;
              this.something_went_wrong = true;
          });
        },
        

        update() {
              this.btnLoading = true;
              axios.defaults.headers.common = {
                  'X-CSRF-TOKEN': this.csrfToken
              };
                const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
                let formData = new FormData();
                formData.append('id', this.$route.params.id);
                formData.append('image', this.row.image);
                formData.append('title', this.row.title);
                formData.append('content', this.row.content);
                formData.append('status', this.row.status);
                formData.append('accessToken', this.accessToken);
                formData.append('_method', 'PUT');
                for( var i = 0; i < this.row.tagsSelected.length; i++ ){
                    let file = this.row.tagsSelected[i];
                    formData.append('tags[' + i + ']', file);
                }
                axios.post('/api/v1/dashboard/post', formData, config)
                .then(res => {
                    this.btnLoading = false;
                    if(res.data.statusCode == 201) {
                        this.$noty.info(this.$i18n.messages[this.$i18n.locale].app.success_msg);
                        this.$router.push({ name: 'posts' })
                    } else {
                        this.$noty.error('Opps<br/>'+res.data.err);
                    }
                })
                .catch(err => {
                    this.btnLoading = false;
                    this.$noty.error(this.$i18n.messages[this.$i18n.locale].app.error_msg);
                });
            },

        onImageChange(e){
          const file = e.target.files[0];
          this.row.preview = URL.createObjectURL(file);
          this.row.image = file;
        },

        onTagAdded(slug) {
            this.row.tagsSelected.push(slug.value);
        },

        onTagRemoved(slug) {
            let found = this.row.tagsSelected.indexOf(slug.value)
            this.row.tagsSelected.splice(found, 1);
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
