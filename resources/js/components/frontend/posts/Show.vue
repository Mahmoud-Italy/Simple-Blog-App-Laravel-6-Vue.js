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

            <div class="row text-center mtop10per mH400" v-if="!dataLoading && !something_went_wrong && no_data_found">
              <div v-if="no_data_found" class="w100per">
                <h5>No data found.</h5>
                <button class="btn btn-info br20px" @click="fetchData('', true)">
                  <i class="fa fa-refresh f13"></i> Try again
                </button>
              </div>
             </div>

            
          <div v-if="!dataLoading && !something_went_wrong && !no_data_found">

            <h1 class="mt-4">{{ row.title }}</h1>
            <p class="lead"> by {{ row.author_name }}</p>
            <p>Posted on {{ row.created_at }}</p>
            <hr>
            <img class="img-fluid rounded" :src="row.image" alt="" style="width: 100%;height: 500px">
            <hr>

           <p class="lead" v-html="row.content"></p>
          <hr>

          <h1 class="mt-4"><br/><br/><br/>COMMENT ( {{ total_comment}} )</h1>
          <hr>

            <div class="media mb-4" v-for="(com, index) in comments" :key="index">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="" style="width: 50px;height: 50px">
              <div class="media-body">
                <h5 class="mt-0">{{ com.name }}
                  <button v-if="accessToken == com.id" class="pull-right" @click="delComment(com.id)" style="border-style: none">x</button>
                </h5>
                <p>{{ com.comment }}</p>
                </div>
           </div>

           <!-- Pagination -->
            <ul v-if="total_comment > 20" class="pagination justify-content-center mb-4">
              <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a class="page-link" href="javascript:" @click="fetchComment(pagination.prev_page_url)">&larr; Older</a>
              </li>
              <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a class="page-link" @click="fetchComment(pagination.next_page_url)">Newer &rarr;</a>
              </li>
            </ul>

         <hr>

        <!-- Comments Form -->
        <div class="card my-4" v-if="accessToken">
          <h5 class="card-header">Leave a Comment:</h5>

              <div class="card-body">
                <form @submit.prevent="addComment()">
                  <div class="form-group">
                    <textarea class="form-control" rows="3" v-model="row.comment"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary h38 " :disabled="btnLoading">
                    <span v-if="!btnLoading">Submit</span>
                    <span v-if="btnLoading"><div class="loader sx-loader"></div></span>
                  </button>
                </form>
              </div>
            </div>
                      
          </div>
      </div>



    
      <div class="col-md-4">

        <!-- Tags Widget -->
        <div class="card my-4">
          <h5 class="card-header">Tags</h5>
          <div class="card-body">
              
            <div class="row mH50" v-if="tagsLoading">
                <div class="loader" style="left: 42%"></div>
            </div>

             <div class="row" v-if="!tagsLoading">
              <div class="col-lg-6" v-for="(tag, index) in row.tags" :key="index">
                  <a href="javascript:;">{{ tag.value }}</a>
              </div>
            </div>

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
            title: '',
            image: '',
            content: '',
            tags: [],
            comment: '',
          },
          btnLoading: false,
          dataLoading: true,
          tagsLoading: true,
          commentLoading: false,
          no_data_found: false,
          something_went_wrong: false,
          comments: [],
          pagination: {},
          total_comment: 0,
          csrfToken: '',
          accessToken: '',
        }
    },
    computed: {},
    created() {

      if(localStorage.getItem('accessToken')) {
        this.accessToken = localStorage.getItem('accessToken');
      }
      this.fetchData();
      this.fetchComment('', true);
    },
    methods: {
      
      fetchData() {
         this.dataLoading = true;
          axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let formData = new FormData();
          formData.append('id', this.$route.params.id);
          formData.append('accessToken', this.accessToken);
          axios.post('/api/v1/post/show', formData, config)
          .then(res => {
              this.dataLoading = false;
              this.tagsLoading = false;
              if(res.data.statusCode == 200) {
                this.row.image = res.data.data.image;
                this.row.title = res.data.data.title;
                this.row.content = res.data.data.content;
                this.row.created_at = res.data.data.created_at;
                this.row.author_name = res.data.data.author_name;
                this.row.tags = res.data.data.tags;
              } else {
                this.something_went_wrong = true;
              }
          })
          .catch(err => {
              this.dataLoading = false;
              this.tagsLoading = false;
              this.something_went_wrong = true;
          });
      },

      fetchComment(page_url, loading=false, concat=false) {
          if(loading) { this.commentLoading = true; }
          axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let vm = this;
          let formData = new FormData();
          formData.append('post_id', this.$route.params.id);
          formData.append('accessToken', this.accessToken);
          page_url = page_url || '/api/v1/post/comments';
          axios.post(page_url, formData, config)
          .then(res => {
              this.commentLoading = false;
              if(concat) {
                this.comments = vm.data.concat(res.data.data.data);
              } else {
                this.comments = res.data.data.data;
              }
              if(res.data.data.meta.total) {
                  this.total_comment = res.data.data.meta.total;
                  vm.makePagination(res.data.data.meta)
                }
          })
          .catch(err => {
              this.commentLoading = false;
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

      addComment() {
        this.btnLoading = true;
        axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let formData = new FormData();
          formData.append('post_id', this.$route.params.id);
          formData.append('comment', this.row.comment);
          formData.append('accessToken', this.accessToken);
          axios.post('/api/v1/post/comment', formData, config)
          .then(res => {
              this.btnLoading = false;
              this.row.comment = '';
              this.fetchComment('',false,false);
          })
          .catch(err => {
              this.row.comment = '';
              this.btnLoading = false;
          });
      },


      delComment(e) {
        axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let formData = new FormData();
          formData.append('id', e);
          formData.append('accessToken', this.accessToken);
          formData.append('_method', 'DELETE');
          axios.post('/api/v1/post/comment', formData, config)
          .then(res => {
              this.fetchComment('',false,true);
          })
          .catch(err => {
              this.fetchComment('',false,true);
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
    .mH400 { min-height: 400px }
    .mH50 { min-height: 50px }
    .w100per { width: 100% }
    .br20px { border-radius: 20px }
    .f13 { font-size: 13px }
    .h38 { height: 38px } 
    .br0 { border-radius: 0 }
</style>
