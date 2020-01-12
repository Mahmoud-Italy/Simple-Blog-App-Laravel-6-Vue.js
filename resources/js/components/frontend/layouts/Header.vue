<template>
	<div class="">
		
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		    <div class="container">
		      <router-link :to="{ name: 'home' }" class="nav-link text-white">
            <img src="/assets/frontend/images/logo.png" style='height: 22px'>
          </router-link>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" 
              aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="navbar-toggler-icon"></span>
		      </button>
		      <div class="collapse navbar-collapse" id="navbarResponsive">
		        <ul class="navbar-nav ml-auto">
		          <li class="nav-item" :class="{ 'active' : this.$route.path == '/' }">
		          	<router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
		          </li>
		          <li class="nav-item" :class="{ 'active' : this.$route.path == '/contact' }">
		            <router-link :to="{ name: 'contact' }" class="nav-link">Contact Us</router-link>
		          </li>

		          <li v-if="!accessToken" class="nav-item" :class="{ 'active' : this.$route.path == '/login' }">
		            <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
		          </li>
		          <li v-if="!accessToken" class="nav-item" :class="{ 'active' : this.$route.path == '/signup' }">
		            <router-link :to="{ name: 'signup' }" class="nav-link">Signup</router-link>
		          </li>

              <li v-if="accessToken" class="nav-item">
                <a href="javascript:;" class="nav-link">{{ username }}</a>
              </li>
              <li v-if="is_author == 1 || is_admin == 1" class="nav-item">
                <a href="/dashboard/explore" class="nav-link">Dashboard</a>
              </li>
              <li v-if="accessToken" class="nav-item">
                <a href="javascript:;" class="nav-link" @click="logout()">Logout</a>
              </li>

		        </ul>
		      </div>
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
            user: {
                user_id: '',
                image: '',
                name: '',
                email: '',
                is_admin: '',
            },
            search: '',
            csrfToken: '',

            accessToken: false,
            username: '',
            is_author: false,
            is_admin: false,
        }
    },
    computed: {},
    created() {

      if(localStorage.getItem('accessToken')) {
        this.accessToken = localStorage.getItem('accessToken');
      }

      if(localStorage.getItem('username')) {
        this.username = localStorage.getItem('username');
      }

      if(localStorage.getItem('is_author')) {
        this.is_author = localStorage.getItem('is_author');
      }

      if(localStorage.getItem('is_admin')) {
        this.is_admin = localStorage.getItem('is_admin');
      }

    },
    methods: {
      
        logout() {
            localStorage.removeItem('accessToken');
            localStorage.removeItem('username');
            localStorage.removeItem('is_author');
            localStorage.removeItem('is_admin');
            this.$router.push({ name: 'login' })
        },

    }
  }
</script>