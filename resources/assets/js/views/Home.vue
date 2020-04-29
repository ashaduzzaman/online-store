<template>
    <v-app>
        <!-- <v-card 
        class="mx-auto mt-0 pa-4"
        max-width="500"
        color="rgb(255,227,63)"
        flat
        tile
        > -->
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
                v-for="card in cards"
                :key="card.name"
                :class="`d-flex justify-center mb-3`"
                >
                    <v-card 
                    width="200px" 
                    class="mx-auto" 
                    @click="selectedCategory(card)"
                    >
                        <v-img
                        :src="card.src"
                        class=""
                        height="180px"
                        >
                        <!-- <v-card-title v-text="card.title"></v-card-title> -->
                        </v-img>
                        <v-card-actions class="justify-center">
                        <!-- <v-spacer></v-spacer> -->
                        <p style="font-size:20px;">{{card.title}}</p>
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
      cards: [
        { title: 'Baby Food', src: '/images/Baby.png', flex: 6 },
        { title: 'Health', src: '/images/Health-Hygiene.png', flex: 6 },
        { title: 'Chocolate', src: '/images/Chocolates-Product-Category-10-1.png', flex: 6 },
        { title: 'Electronics', src: '/images/Electronics-Product-Category.png', flex: 6 },
      ],
    }),
    beforeMount(){
        axios.get('/api/')
            .then(response => {
                console.log(response.data)
                this.categories = response.data
            })
            .catch(error => {
                console.error(error);
            })
    },
    methods:{
        selectedCategory(item){
            console.log(item);
        axios.get('/api/products/category='+ item.id)
            .then(response => {
                // console.log(response.data)
                // this.categories = response.data
            })
            .catch(error => {
                console.error(error);
            })
        }
    }
    

}
</script>

<style scoped>
    
    .main{
        width: 40%;
        background-color: rgb(255,227,63);
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
    
</style>