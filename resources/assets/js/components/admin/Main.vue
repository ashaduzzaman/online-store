<template class="ma-0 pa-0" style="padding: 0px;">
	<div>
        <v-toolbar flat color="white" class="mt-6">
            <v-toolbar-title class="grey--text">Dashboard</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
        </v-toolbar>

        <v-container fluid class="mt-4">
            <v-row dense>
            <v-col
                v-for="card in cards"
                :key="card.title"
                :cols="card.flex"
                :class="`d-flex justify-center mb-3`"
                >
                    <v-card 
                    max-width="230px" 
                    class="mx-auto" 
                    @click="selectedCategory(card)"
                    >
                        <v-img
                        class="red--text align-end"
                        :src="card.src"
                        height="180px"
                        >
                        </v-img>
                        <v-card-title v-text="card.title"></v-card-title>
                        <v-card-subtitle style="font-size:30px;color:blue;">{{ card.count.length }}</v-card-subtitle>
                        <v-card-actions class="justify-center">
                        <!-- <v-spacer></v-spacer> -->
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
                
                    <!-- <div>
                        <a href='/admin/orders'>Orders ({{orders.length}})</a>
                    </div>
                    <hr>
                    <div>
                        <a href='/admin/products'>Products ({{products.length}})</a>
                    </div>
                    <div>
                        <a href='/admin/users'>Users ({{users.length}})</a>
                    </div> -->
        </v-container>
    </div>
</template>
<script>
	export default {
        data(){
            return {
                user : null,
                orders : [],
                products : [],
                users : [],
                cards: [
                    { title: 'Number of orders', subtitle: 'orders', src: '/images/orders.jpg', flex: 4, count: [] },
                    { title: 'Number of Products', subtitle: 'products', src: '/images/products.jpg', flex: 4, count: [] },
                    { title: 'Number of Users', subtitle: 'users', src: '/images/user.jpg', flex: 4, count: [] }
                ]
            }
        },
        mounted(){
            axios.get('/api/users/')
            .then(response => {
                // this.users = response.data
                this.cards[2].count = response.data
            })
            .catch(error => {
                console.error(error);
            })

            axios.get('/api/products/')
            .then(response => {
                // this.products = response.data
                this.cards[1].count = response.data
            })
            .catch(error => {
                console.error(error);
            })

            axios.get('/api/orders/')
            .then(response => {
                // this.orders = response.data
                this.cards[0].count = response.data
            })
            .catch(error => {
                console.error(error);
            })         
        }
    }
</script>
<style scoped>
    .big-text {
        font-size: 28px;
    }
	.product-box {
        border: 1px solid #cccccc;
        padding: 10px 15px;
        height: 20vh
    }
</style>