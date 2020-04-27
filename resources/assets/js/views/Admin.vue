<template>
    <div>
        <v-app-bar
      dark
      app
    >
      <!-- <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon> -->

      <v-toolbar-title>E-Commerce Admin Panel</v-toolbar-title>
      <v-spacer></v-spacer>
      <!-- <v-btn>Login</v-btn> -->
      <div class="navbar-nav ml-auto">
            <v-btn router :to="{ name: 'login' }" v-if="!isLoggedIn">Login</v-btn>
            <v-btn router :to="{ name: 'register' }" v-if="!isLoggedIn">Register</v-btn>
            <v-btn small v-if="isLoggedIn" @click="logout" color="white" class="black--text"> Logout</v-btn>
        </div>
    </v-app-bar>

        <v-navigation-drawer
        v-model="drawer"
        app
        dark
        width="200"
      >
        <v-list
          dense
          nav
          class="py-0"
        >
          <v-list-item two-line class="px-0">
            <v-list-item-avatar>
              <img src="https://randomuser.me/api/portraits/men/81.jpg">
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title router :to="{ name: 'userboard' }" v-if="user_type == 0">Hi, {{name}}</v-list-item-title>
              <v-list-item-title router :to="{ name: 'admin' }" v-if="user_type == 1">Hi, {{name}}</v-list-item-title>
              <!-- <v-list-item-subtitle>Subtext</v-list-item-subtitle> -->
            </v-list-item-content>
          </v-list-item>

          <v-divider></v-divider>

          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            @click="setComponent(item.component)"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
        <!-- <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Admin Dashboard</h2>
        </div> -->
        <v-divider></v-divider>
        <v-container>
            <v-row no-gutters>
                <v-col lg="2" sm="0" xs="0">
                <!-- <div class="col-md-3"> -->
                    <!-- <ul style="list-style-type:none">
                      <li class="active"><button class="btn" @click="setComponent('main')">Dashboard</button></li>
                      <li><button class="btn" @click="setComponent('orders')">Orders</button></li>
                      <li><button class="btn" @click="setComponent('products')">Products</button></li>
                      <li><button class="btn" @click="setComponent('users')">Users</button></li>
                    </ul> -->
                <!-- </div> -->
                </v-col>
                <v-col lg="10" sm="12" xs="12">
                    <div>
                        <component :is="activeComponent"></component>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
    import Main from '../components/admin/Main'
    import Users from '../components/admin/Users'
    import Products from '../components/admin/Products'
    import Delivered from '../components/admin/Delivered'
    import Orders from '../components/admin/Orders'
    import Category from '../components/admin/Category'

    
    export default {
      name: 'App',
//   components: { Navbar },
        data(){
            return {
                name: null,
                user_type: 0,
                isLoggedIn: localStorage.getItem('jwt') != null,
                user : null,
                activeComponent : null,
                drawer: true,
                items: [
                { title: 'Dashboard', icon: 'mdi-view-dashboard', component: 'main' },
                { title: 'Orders', icon: 'mdi-image', component: 'orders' },
                { title: 'Delivered Orders', icon: 'mdi-image', component: 'delivered' },
                { title: 'Category', icon: 'mdi-image', component: 'category' },
                { title: 'Products', icon: 'mdi-help-box', component: 'products' },
                { title: 'Users', icon: 'mdi-help-box', component: 'users' },
                ],
                color: 'primary',
            }
        },
        components : {
            Main, Users, Products, Orders, Delivered, Category
        },
        mounted() {
            this.setDefaults()
        },
        beforeMount(){
            this.setComponent(this.$route.params.page)
            this.user = JSON.parse(localStorage.getItem('user'))
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },
        methods : {
            setComponent(value){
                switch(value) {
                    case "users":
                        this.activeComponent = Users
                        this.$router.push({name : 'admin-pages', params : {page: 'users'}})
                        break;
                    case "orders":
                        this.activeComponent = Orders
                        this.$router.push({name : 'admin-pages', params : {page: 'orders'}})
                        break;
                    case "delivered":
                        this.activeComponent = Delivered
                        this.$router.push({name : 'admin-pages', params : {page: 'delivered'}})
                        break;
                    case "category":
                        this.activeComponent = Category
                        this.$router.push({name : 'admin-pages', params : {page: 'category'}})
                        break;
                    case "products":
                        this.activeComponent = Products
                        this.$router.push({name : 'admin-pages', params : {page: 'products'}})
                        break;
                    default:
                        this.activeComponent = Main
                        this.$router.push({name : 'admin'})
                        break;
                }
            },
            setDefaults(){
            if(this.isLoggedIn){
                let user        = JSON.parse(localStorage.getItem('user'))
                this.name       = user.name
                this.user_type  = user.is_admin
            }
            },
            change(){
                this.isLoggedIn = localStorage.getItem('jwt') != null
                this.setDefaults()

            },
            logout(){
                localStorage.removeItem('jwt')
                localStorage.removeItem('user')
                this.change()
                this.$router.push('/')
            }
        }
    }
</script>
<style scoped>
    .hero-section {
        height: 20vh;
        background: #ababab;
        align-items: center;
        margin-bottom: 20px;
        margin-top: -20px;
    }
    .title {
        font-size: 60px;
        color: #ffffff;
    }
</style>