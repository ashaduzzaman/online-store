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
                :key="card.title"
                :cols="card.flex"
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
                        <p style="font-size:20px;">Baby Foods</p>
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
      cards: [
        { title: 'Pre-fab homes', src: '/images/Baby.png', flex: 6 },
        { title: 'Favorite road trips', src: '/images/Health-Hygiene.png', flex: 6 },
        { title: 'Best airlines', src: '/images/Chocolates-Product-Category-10-1.png', flex: 6 },
        { title: 'Best airlines dhaka', src: '/images/Electronics-Product-Category.png', flex: 6 },
      ],
    }),
    methods:{
        selectedCategory(item){
            console.log(item);
        }
    }
    

}
</script>

<style lang="scss" scoped>
    
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