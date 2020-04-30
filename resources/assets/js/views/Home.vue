<template>
    <v-app>
    <div class="main">     
        <v-container fluid>
            <v-text-field
                solo
                label="Search Here"
                append-icon="mdi-magnify"
                class="pa-3 ma-2"
            ></v-text-field>

            <v-row dense>
                <v-col
                v-for="card in categories"
                :key="card.name"
                :class="`d-flex justify-center mb-3`"
                cols="6"
                >
                    <v-card 
                    width="200px" 
                    class="mx-auto"
                    @click="selectedCategory(card)"
                    >
                        <v-img
                        :src="card.imgUrl"
                        class=""
                        height="180px"
                        >
                        </v-img>
                        <!-- <img height="180px" v-bind:src="card.imgUrl" /> -->
                        <v-card-actions class="justify-center">
                        <!-- <v-spacer></v-spacer> -->
                        <p style="font-size:20px;">{{card.name}}</p>
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
    data: () => ({
        categories: [],
    }),
    beforeMount(){
        axios.get('/api/')
            .then(response => {
                console.log(response.data[0].imgUrl)
                this.categories = response.data
            })
            .catch(error => {
                console.error(error);
            })
    },
    methods:{
        selectedCategory(item){
            this.$router.push({ path: "/products/category="+item.id })
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
    @media only screen and (max-width: 700px) {
        .main{   
           width: 100%;
           padding-left: 8px;
           padding-right: 8px;

        }
    }
</style>>