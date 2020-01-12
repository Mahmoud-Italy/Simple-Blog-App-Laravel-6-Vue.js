<template>
    <div class="">
      <Header></Header>

      <div class="container">
        <div class="row">

          <div class="col-md-8">

            <div class="row mtop10per mH400" v-if="dataLoading">
              <div class="loader"></div>
            </div>

            <div class="row text-center mtop10per mH400" v-if="!dataLoading && something_went_wrong">
              <div v-if="something_went_wrong" class="w100per">
                <h5>Something went wrong.</h5>
                <button class="btn btn-danger br20px" @click="fetchData('', true)">
                  <i class="fa fa-refresh f13"></i> Try again
                </button>
              </div>
            </div>

            <!-- <div class="row text-center mtop10per mH400" v-if="!something_went_wrong && !total_data">
              <div v-if="!total_data" class="w100per">
                <h5>No data found.</h5>
                <button class="btn btn-info br20px" @click="fetchData('', true)">
                  <i class="fa fa-refresh f13"></i> Try again
                </button>
              </div>
             </div> -->

            
            <div v-if="!dataLoading && !something_went_wrong && total_data">
              <h1 class="mt-4" v-if="tag">TAG: {{tag}}</h1>
              <h1 class="my-4"></h1>
              <div class="card mb-4" 
                  v-for="(row, index) in data" :key="index">
                <img class="card-img-top" :src="row.image" alt="Card image cap" style="width:100%;height: 500px">
                <div class="card-body">
                  <h2 class="card-title">{{ row.title }}</h2>
                  <p class="card-text">{{ row.short_content }}</p>
                  <router-link :to="{ name: 'show', params:{name: row.permalink, id: row.id}}" class="btn btn-primary">
                      Read More &rarr;
                  </router-link>
                </div>
                <div class="card-footer text-muted">
                  Posted on {{ row.created_at }} by {{ row.author_name }}
                </div>
              </div>

            <!-- Pagination -->
            <ul v-if="!dataLoading && !something_went_wrong  && total_data !== 0" class="pagination justify-content-center mb-4">
              <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a class="page-link" href="javascript:" @click="fetchData(pagination.prev_page_url)">&larr; Older</a>
              </li>
              <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a class="page-link" @click="fetchData(pagination.next_page_url)">Newer &rarr;</a>
              </li>
            </ul>
          </div>

      </div>



    
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <form @submit.prevent="fetchData('',false,true)">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." v-model="search">
                <span class="input-group-btn">
                  <button class="btn btn-secondary h38 br0" type="submit" :disabled="btnLoading">
                    <span v-if="!btnLoading">Go!</span>
                    <span v-if="btnLoading"><div class="loader sx-loader"></div></span>
                  </button>
                </span>
              </div>
            </form>
          </div>
        </div>

        <!-- Tags Widget -->
        <div class="card my-4">
          <h5 class="card-header">Tags</h5>
          <div class="card-body">
              
            <div class="row mH50" v-if="tagsLoading">
                <div class="loader" style="left: 42%"></div>
            </div>

             <div class="row" v-if="!tagsLoading">
              <div class="col-lg-6" v-for="(tag, index) in tags" :key="index">
                  <a href="javascript:;" @click="opnTag(tag.tag)">{{ tag.tag }}</a>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->

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
          btnLoading: false,
          dataLoading: true,
          tagsLoading: true,
          something_went_wrong: false,
          data: [],
          total_data: 0,
          tags: [],
          pagination: {},
          search: '',
          tag: '',
          csrfToken: '',
          accessToken: '',
        }
    },
    computed: {},
    created() {
      if(this.$route.params.id) {
        this.tag = this.$route.params.id;
      }
      if(localStorage.getItem('accessToken')) {
        this.accessToken = localStorage.getItem('accessToken');
      }
      this.fetchData('', true);
    },
    methods: {
      
      fetchData(page_url, loading=false, btn=false) {
          if(loading) { this.dataLoading = true; }
          if(btn) { this.btnLoading = true; }
          this.something_went_wrong = false;
          axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let vm = this;
          let formData = new FormData();
          formData.append('search', this.search);
          formData.append('tag', this.tag);
          formData.append('accessToken', this.accessToken);
          page_url = page_url || '/api/v1/posts';
          axios.post(page_url, formData, config)
            .then(res => {
                this.tagsLoading = false;
                this.dataLoading = false;
                this.btnLoading = false;
                this.data = res.data.data.data;
                this.tags = res.data.data.tags;
                if(res.data.data.meta.total) {
                  this.total_data = res.data.data.meta.total;
                  vm.makePagination(res.data.data.meta)
                }
            })
            .catch(err => {
                this.dataLoading = false;
                this.tagsLoading = false;
                this.btnLoading = false;
                this.something_went_wrong = true;
            });
        }, 

        makePagination(meta) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: meta.next_page_url,
                prev_page_url: meta.prev_page_url
            }
            this.pagination = pagination;
        },

        opnTag(i) {
          this.tag = i;
          this.fetchData('', true);
        }



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
    .mH50 { min-height: 50px }
    .mH400 { min-height: 400px }
    .w100per { width: 100% }
    .br20px { border-radius: 20px }
    .f13 { font-size: 13px }
    .h38 { height: 38px } 
    .br0 { border-radius: 0 }
</style>
