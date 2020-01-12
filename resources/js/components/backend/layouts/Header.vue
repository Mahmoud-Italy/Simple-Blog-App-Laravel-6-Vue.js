<template>
    <div class="">

         <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i class="fa fa-ellipsis-v icon-fixed"></i>
                </a>
                <div class="navbar-content">
                    <form class="search-form" method="get">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-search icon-fixed"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="navbarForm" :placeholder="$t('app.search')" name="search" v-model="search">
                        </div>
                    </form>
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown nav-profile">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="/assets/backend/images/avatar.png" alt="" style="width: 35px;height: 35px">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="figure mb-3">
                                        <img src="/assets/backend/images/avatar.png" alt="" style="width: 65px;height: 65px">
                                    </div>
                                    <div class="info text-center">
                                        <p class="name font-weight-bold mb-0 fontana">{{ username }}</p>
                                    </div>
                                </div>
                                <div class="dropdown-body">

                                    <ul class="profile-nav p-0 pt-3">
                                        <li class="nav-item">
                                            <a @click="logout()" class="nav-link pointer">
                                                <i data-feather="log-out"></i>
                                                <i class="fa fa-power-off icon-fixed"></i>
                                                <span class="fontana">{{ $t('app.logout') }}</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            
    </div>
</template>

<script>  
  export default {
    name: 'Header',
    mounted() {},
    data() {
        return {
            search: '',
            csrfToken: '',
            accessToken: '',
            username: '',
            is_admin: '',
            is_author: '',
        }
    },
    computed: {},
    created() {
      if(localStorage.getItem('accessToken')) {
        this.accessToken = localStorage.getItem('accessToken');
      }
      if(localStorage.getItem('is_admin')) {
        this.is_admin = localStorage.getItem('is_admin');
      }
      if(localStorage.getItem('is_author')) {
        this.is_author = localStorage.getItem('is_author');
      }
      if(localStorage.getItem('username')) {
        this.username = localStorage.getItem('username');
      }
      if(this.$route.query['search']) {
        this.search = this.$route.query['search'];
      }
    },
    methods: {
        

        logout() {
            localStorage.removeItem('accessToken');
            localStorage.removeItem('username');
            localStorage.removeItem('is_author');
            localStorage.removeItem('is_admin');
            this.$router.push({ name: 'cp-login'} );
        },
        
    }
  }
</script>