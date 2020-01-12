<template>
    <div class="">
    
    <nav class="sidebar">
      <div class="sidebar-header">
        <router-link :to="{ name: 'dashboard' }">
          <center><img src="/assets/frontend/images/logo.png" style="width: 100px" alt=""></center>
        </router-link>
        <div @click="toggleMenu()" ref="sidebar-toggler" class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <div class="sidebar-body" style="overflow-y: auto">
        <ul class="nav">

          <li class="nav-item nav-category f14">{{ $t('nav.main') }}</li>
          <li class="nav-item"
            :class="{ 'active' : this.$route.path == '/dashboard/explore' }">
            <router-link :to="{ name: 'dashboard' }" class="nav-link active">
              <i class="fa fa-fort-awesome icon-fixed"></i>
              <span class="link-title m-left15">{{ $t('nav.dashboard') }}</span>
            </router-link>
          </li>

          <li class="nav-item nav-category f14">Blog</li>
          <li class="nav-item"
              :class="{ 'active' : this.$route.path == '/dashboard/posts' ||  this.$route.path == '/dashboard/post/create' }">
            <router-link :to="{ name: 'posts' }" class="nav-link">
              <i class="fa fa-edit icon-fixed"></i>
              <span class="link-title m-left15">POSTS</span>
            </router-link>
          </li>
          <li class="nav-item" 
            :class="{ 'active' : this.$route.path == '/dashboard/comments' }">
            <router-link :to="{ name:'comments' }" class="nav-link">
              <i class="fa fa-comment icon-fixed"></i>
              <span class="link-title m-left15">COMMENTS</span>
            </router-link>
          </li>
          
          <li class="nav-item nav-category f14" v-if="is_admin == 1">USERS</li>
          <li class="nav-item" v-if="is_admin == 1"
            :class="{ 'active' : this.$route.path == '/dashboard/members' }">
            <router-link :to="{ name:'members' }" class="nav-link">
              <i class="fa fa-child icon-fixed"></i>
              <span class="link-title m-left15">MEMBERS</span>
            </router-link>
          </li>
          <li class="nav-item" v-if="is_admin == 1"
            :class="{ 'active' : this.$route.path == '/dashboard/authors' }">
            <router-link :to="{ name:'authors' }" class="nav-link">
              <i class="fa fa-user-circle icon-fixed"></i>
              <span class="link-title m-left15">AUTHORS</span>
            </router-link>
          </li>

          <li class="nav-item nav-category f14" v-if="is_admin == 1">MESSAGES</li>
          <li class="nav-item" v-if="is_admin == 1"
            :class="{ 'active' : this.$route.path == '/dashboard/messages' }">
            <router-link :to="{ name:'messages' }" class="nav-link">
              <i class="fa fa-envelope icon-fixed"></i>
              <span class="link-title m-left15">MESSAGES</span>
            </router-link>
          </li>
          
          <li class="nav-item nav-category f14" v-if="is_admin == 1">{{ $t('nav.settings') }}</li>
          <li class="nav-item" v-if="is_admin == 1"
            :class="{ 'active' : this.$route.path == '/dashboard/settings' }">
            <router-link :to="{ name:'settings' }" class="nav-link">
              <i class="fa fa-gear icon-fixed"></i>
              <span class="link-title m-left15">{{ $t('nav.settings') }}</span>
            </router-link>
          </li>


        </ul>
      </div>
    </nav>

        
    </div>
</template>

<script>  
  export default {
    name: 'Navigation',
    mounted() {},
    data() {
        return {
          accessToken: '',
          is_author: false,
          is_admin: false,
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
    },
    methods: {
        toggleMenu() {
          let para = document.querySelectorAll("body");
          let parax = para[para.length-1];
          let classes = parax.classList;
          if(parax.classList.contains('sidebar-folded')) {
            parax.classList.remove('sidebar-folded');
            $(this.$refs['sidebar-toggler']).removeClass('active').addClass('not-active');
          } else {
            parax.classList.add('sidebar-folded');
            $(this.$refs['sidebar-toggler']).removeClass('not-active').addClass('active');
          }
        },        
    }
  }
</script>

<style scoped="">
  .loader {
        position: absolute;
        left: 45%;
        transform: translate(-50%, -50%);
        border: 2px solid #f3f3f3;
        border-top: 2px solid #686767;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  .spin {
        animation: spin 3s linear infinite;
        color: #9b9b9b;
    }
  .cursor { cursor: pointer }
</style>
