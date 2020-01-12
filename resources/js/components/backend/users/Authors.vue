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
                  <li class="breadcrumb-item fontana"><router-link :to="{ name: 'dashboard' }">{{ $t('app.dashboard') }}</router-link></li>
                  <li class="breadcrumb-item fontana active" aria-current="page">AUTHORS</li>
                </ol>
              </nav>

              <div class="row" v-if="pgLoading">
                <div class="loader"></div>
              </div>

              <div class="row" v-if="!pgLoading" style="display: unset">
                <div v-if="something_went_wrong" class="something_went_wrong">
                    <h5 class="fontana">{{ $t('app.something_went_wrong') }}</h5>
                    <button class="btn btn-primary fontana" style="border-radius: 20px" @click="fetchData()">
                      <i class="fa fa-refresh f14"></i> {{ $t('app.try_again') }}
                    </button>
                </div>
              </div>

              <div class="row" v-if="!pgLoading && !something_went_wrong">

                <div class="col-md-8 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h6 class="card-title fontana">{{ $t('app.all_data') }} ( {{ total_data }} )</h6>
                      
                      <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr  class="head-tbl">
                                <th class="text-center" style="width: 5%">#</th>
                                <th class="text-center fontana" style="width: 15%">NAME</th>
                                <th class="text-center fontana" style="width: 15%">EMAIL</th>
                                <th class="text-center fontana" style="width: 25%">ROLES</th>
                                <th class="text-center fontana" style="width: 10%">ACTION</th>
                              </tr>
                            </thead>
                            <tbody v-if="dataLoading">
                                <tr ><td colspan="5"><div class="loader sm-loader" style="left: 50%"></div></td></tr>
                            </tbody>
                            <tbody v-if="!dataLoading">
                              <tr v-if="total_data == 0"><td colspan="5" class="text-center"> {{ $t('app.no_data') }}</td></tr>
                              <tr v-if="total_data != 0" v-for="(row, index) in data" :key="index" v-bind:key="row.id" :ref="'row_'+row.id" 
                                  :class="(row.status == 0) ? 'deactive' : 'active' ">
                                <td class="text-center">{{ index+1 }}</td>
                                <td class="text-center">{{ row.name }}</td>
                                <td class="text-center">{{ row.email }}</td>
                                <td class="text-center">
                                  <span class="badge badge-primary" v-if="row.has_creates">CREATE</span>
                                  <span class="badge badge-secondary" v-if="row.has_shows">SHOW</span>
                                  <span class="badge badge-success" v-if="row.has_updates">UPDATE</span>
                                  <span class="badge badge-danger" v-if="row.has_deletes">DELETE</span>
                                </td>
                                <td class="text-center">
                                     <button type="button" class="btn btn-secondary" :class="(row.status === 1) ? 'btn-secondary' : 'btn-light' "
                                              @click="row.active_loading = true; activeData(row.id)" :disabled="row.active_loading">
                                            <span class="fontana 12" v-if="row.status === 0 && !row.active_loading">{{ $t('app.active') }}</span>
                                            <span class="fontana 12" v-if="row.status === 1 && !row.active_loading">{{ $t('app.deactive') }}</span>
                                            <span v-if="row.active_loading"><div class="loader sx-loader"></div></span>
                                      </button>
                                      <button type="button" class="btn btn-success"
                                              @click="editData(row)" :disabled="row.edit_loading">
                                            <span class="fontana 12" v-if="!row.edit_loading">{{ $t('app.edit') }}</span>
                                            <span v-if="row.edit_loading"><div class="loader sx-loader"></div></span>
                                      </button>
                                      <button type="button" class="btn btn-danger"
                                              @click="row.del_loading = true;  deleteData(row.id)" :disabled="row.del_loading">
                                            <span class="fontana 12" v-if="!row.del_loading">{{ $t('app.delete') }}</span>
                                            <span v-if="row.del_loading"><div class="loader sx-loader"></div></span>
                                      </button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                      </div>
                    
                      <nav  v-if="total_data !== 0" aria-label="Page navigation example" v-bind:style="{'margin-top':'20px'}">
                        <ul class="pagination">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link" href="javascript:" @click="fetchData(pagination.prev_page_url)">Previous</a>
                            </li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link" href="javascript:" @click="fetchData(pagination.next_page_url)">Next</a>
                            </li>
                        </ul>
                        <p><i>Page {{ pagination.current_page }} or {{ pagination.last_page }}</i></p>
                      </nav>
                    </div>
                  </div>
                </div>




                <div class="col-md-4">
                  <div class="card">
                    <div class="card-body">
                      <h6 class="card-title">{{ $t('app.create_new') }}</h6>
                      <form @submit.prevent="addNew" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="txt1">NAME</label>
                          <input type="text" id="txt1" class="form-control" v-model="row.name">
                        </div>
                        <div class="form-group">
                          <label for="txt2">EMAIL</label>
                          <input type="text" id="txt2" class="form-control" v-model="row.email">
                        </div>
                        <div class="form-group">
                          <label for="txt3">PASSWORD</label>
                          <input type="password" id="txt3" class="form-control" v-model="row.password" autocomplete="off" placeholder="*******">
                        </div>
                        <div class="col-12 row">
                          <div class="col-12">
                            <h6 class="card-title"><br/>ROLES</h6>
                          </div>
                          <div class="col-6 form-group">
                            <input type="checkbox" id="txt4" ref="creates" 
                              v-model="row.creates" :value="row.creates" :checked="row.creates" @click="setValue('creates', $event)">
                            <label for="txt4">CREATE</label>
                          </div>
                          <div class="col-6 form-group">
                            <input type="checkbox" id="txt5" ref="shows" 
                              v-model="row.shows" :value="row.shows" :checked="row.shows" @click="setValue('shows', $event)">
                            <label for="txt5">SHOW</label>
                          </div>
                          <div class="col-6 form-group">
                            <input type="checkbox" id="txt6" ref="updates" 
                              v-model="row.updates" :value="row.updates" :checked="row.updates" @click="setValue('updates', $event)">
                            <label for="txt6">UPDATE</label>
                          </div>
                          <div class="col-6 form-group">
                            <input type="checkbox" id="txt7" ref="deletes" 
                              v-model="row.deletes" :value="row.deletes" :checked="row.deletes" @click="setValue('deletes', $event)">
                            <label for="txt7">DELETE</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary" :disabled="btnLoading">
                              <span v-if="!btnLoading">{{ $t('app.submit') }}</span>
                              <div class="loader sx-loader" v-if="btnLoading"></div>
                            </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>
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

  export default {
    name: 'Members',
    components: {
      Navigation,
      Header,
      Footer
    },
    mounted() {},
    data() {
        return {
          row: {
            id: '',
            name: '',
            email: '',
            password: '',
            status: 1,
            is_author: 1,
            creates: false,
            shows: false,
            updates: false,
            deletes: false
          },
          pgLoading: false,
          dataLoading: false,
          btnLoading: false,
          something_went_wrong: false,
          edit: false,
          total_data: 0,
          data: [],
          pagination: {},
          search: '',
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
      if(this.$route.query['search']) {
        this.search = this.$route.query['search'];
      }
      this.fetchData('', true);
    },
    methods: {

      fetchData(page_url, loading=false) {
          if(loading) { this.dataLoading = true; }
          this.something_went_wrong = false;
          axios.defaults.headers.common = {
              'X-CSRF-TOKEN': this.csrfToken
          };
          const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
          let vm = this;
          let formData = new FormData();
          formData.append('search', this.search);
          formData.append('accessToken', this.accessToken);
          page_url = page_url || '/api/v1/dashboard/authors';
          axios.post(page_url, formData, config)
            .then(res => {
                this.pgLoading = false;
                this.dataLoading = false;
                this.data = res.data.data.data;
                this.total_data = res.data.data.meta.total;
                vm.makePagination(res.data.data.meta);
            })
            .catch(err => {
                this.pgLoading = false;
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

        activeData(id) {
            axios.defaults.headers.common = {
                'X-CSRF-TOKEN': this.csrfToken
            };
            const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
            let formData = new FormData();
            formData.append('rowId', id);
            formData.append('modelName', 'User');
            formData.append('accessToken', this.accessToken);
            axios.post('/api/v1/dashboard/row/status', formData, config)
                .then(res => {
                this.fetchData();
                this.$noty.info(this.$i18n.messages[this.$i18n.locale].app.success_msg);
             })
              .catch(err => {
                this.fetchData();
                this.$noty.error(this.$i18n.messages[this.$i18n.locale].app.error_msg);
            });
        },

        addNew() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            if(this.edit === false) {
                 // Add
                this.btnLoading = true;
                let formData = new FormData();
                formData.append('name', this.row.name);
                formData.append('email', this.row.email);
                formData.append('password', this.row.password);
                formData.append('is_author', this.row.is_author);
                formData.append('creates', (this.row.creates) ? 1 : 0);
                formData.append('shows', (this.row.shows) ? 1: 0);
                formData.append('updates', (this.row.updates) ? 1: 0);
                formData.append('deletes', (this.row.deletes) ? 1: 0);
                formData.append('status', this.row.status);
                formData.append('accessToken', this.accessToken);
                axios.post('/api/v1/dashboard/author', formData, config)
                .then(res => {
                    this.row.name = '';
                    this.row.email = '';
                    this.row.password = '';
                    this.row.creates = 0;
                    this.row.updates = 0;
                    this.row.shows = 0;
                    this.row.deletes = 0;
                    this.fetchData();
                    this.btnLoading = false;
                    this.$noty.info(this.$i18n.messages[this.$i18n.locale].app.success_msg);
                })
                 .catch(err => {
                    this.$noty.error(this.$i18n.messages[this.$i18n.locale].app.error_msg);
                  });
            } else {
                // Update
                this.btnLoading = true;
                let formData = new FormData();
                formData.append('id', this.row.id);
                formData.append('name', this.row.name);
                formData.append('email', this.row.email);
                formData.append('password', this.row.password);
                formData.append('is_author', this.row.is_author);
                formData.append('creates', (this.row.creates) ? 1 : 0);
                formData.append('shows', (this.row.shows) ? 1: 0);
                formData.append('updates', (this.row.updates) ? 1: 0);
                formData.append('deletes', (this.row.deletes) ? 1: 0);
                formData.append('status', this.row.status);
                formData.append('accessToken', this.accessToken);
                formData.append('_method', 'PUT');
                axios.post('/api/v1/dashboard/author', formData, config)
                .then(res => {
                    this.row.name = '';
                    this.row.email = '';
                    this.row.password = '';
                    this.row.creates = 0;
                    this.row.updates = 0;
                    this.row.shows = 0;
                    this.row.deletes = 0;
                    this.fetchData();
                    this.btnLoading = false;
                    this.edit = false;
                    this.$noty.info(this.$i18n.messages[this.$i18n.locale].app.success_msg);
                })
                .catch(err => {
                    this.$noty.error(this.$i18n.messages[this.$i18n.locale].app.error_msg);
                });
            }
        },

        editData(data) {
            this.edit = true;
            this.row.id = data.id;
            this.row.name = data.name;
            this.row.email = data.email;

            this.row.creates = data.has_creates;
            this.row.shows = data.has_shows;
            this.row.updates = data.has_updates;
            this.row.deletes = data.has_deletes;
        },

        // set Value for checkbox
        setValue : function(value, event) {
          if (event.target.checked) {
             this.row.$value = 0;
          } else {
             this.row.$value = 1;
          }
        },

        deleteData(id) {
          if(confirm('Are You Sure?')) {
              axios.defaults.headers.common = {
                'X-CSRF-TOKEN': this.csrfToken
            };
            const config = { headers: { 'Content-Type': 'multipart/form-data' }};  
            let formData = new FormData();
            formData.append('id', id);
            formData.append('accessToken', this.accessToken);
            formData.append('_method', 'DELETE');
            axios.post('/api/v1/dashboard/author', formData, config)
              .then(res => {
                  this.fetchData();
                  this.$noty.info(this.$i18n.messages[this.$i18n.locale].app.success_msg);
              })
              .catch(err => {
                this.fetchData();
                  this.$noty.error(this.$i18n.messages[this.$i18n.locale].app.error_msg);
              });
            } else { this.fetchData(); }
        },
      }
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
    .something_went_wrong { text-align:center }
    .something_went_wrong button { margin-top:5px }
    .deactive { background-color: #f9fafb  }
    .sm-loader { width:40px;height:40px;border:2px solid #f3f3f3;border-top:2px solid #686767;position:relative;left:30% }
    .sx-loader { width:20px;height:20px;border:2px solid #f3f3f3;border-top:2px solid transparent;position:relative;left:5%; margin-top: -4px}
    button { height: 30px }
</style>