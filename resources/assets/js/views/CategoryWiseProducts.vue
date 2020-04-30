<template>
    <v-app>
    <div class="main">     
        <v-container fluid>
            <v-row>
                <v-col
                    cols="4"
                    sm="4"
                >
                <div class="logo">
                <v-btn>logo</v-btn>
                </div>
                </v-col>
                <v-col
                    cols="5"
                    sm="5"
                >
                </v-col>
                <v-col
                    cols="3"
                    sm="3"
                >
                <div class="homebtn">
                    <v-btn 
                    icon 
                    color="white"
                    height="50"
                    width="50"
                    @click="gotoHome"
                    ><v-icon size="30">mdi-home</v-icon></v-btn>
                </div>
                </v-col>
            </v-row>
            <v-text-field
                solo
                label="Search Here"
                append-icon="mdi-magnify"
                class="pa-3 ma-2"
            ></v-text-field>

            <v-row dense>
                <v-col
                v-for="card in products"
                :key="card.name"
                :class="`d-flex justify-center mb-3`"
                cols= '6'
                >
                    <v-card 
                    width="200px" 
                    class="mx-auto"
                    >
                        <v-img
                        :src="'/images/'+card.image"
                        class=""
                        height="180px"
                        >
                        </v-img>
                        <v-card-title v-text="card.name"></v-card-title>
                        <v-card-subtitle class="pb-0">{{ card.category.name }}</v-card-subtitle>
                        <v-card-actions class="justify-center">
                        <v-btn depressed color="primary" width="170">
                            <span>Buy</span>
                            <v-spacer></v-spacer>
                            <span>৳ {{ card.price }}</span>
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
    <!-- </v-card> -->
    </v-app>
</template>
<script>
    export default {
        data(){
            return {
                products : [],
                product_qty: 1
            }
        },
        beforeMount(){
            axios.get(`/api/products/category=${this.$route.params.id}`)
            .then(response => {
                console.log(response.data)
                this.products = response.data
            })
            .catch(error => {
                console.error(error);
            })
            axios.get(`/api/products/${this.$route.params.id}`)
            .then(response => {
                this.product = response.data
            })
            .catch(error => {
                console.error(error);
            })       
        },
        methods:{
            gotoHome(){
                this.$router.push({ path: '/' })
            }
        }
    }
</script>

<style scoped>
    
    .main{
        width: 40%;
        background-color: rgb(26,85,156);
        // text-align: center !important;
         margin-right: auto !important;
         margin-left: auto !important;
         padding-left: 5px;
         padding-right: 5px;

    }
    .logo{
        margin-left: 27px;
    }
    .homebtn{
        margin-left: 30px;
    }
    @media only screen and (max-width: 700px) {
        .main{   
           width: 100%;
           padding-left: 8px;
           padding-right: 8px;

        }

        .logo{
            margin-left: 10px;
        }
        .homebtn{
            margin-left: 0px;
        }
    }
</style>>