<template>
	<div>
        <v-toolbar flat color="white" class="mt-6">
            <v-toolbar-title class="grey--text">Product Category List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
        <!-- <button class="btn btn-primary" @click="newProduct">Add New Product</button> -->
            <v-btn class="primary" text depressed @click.stop="dialog = true"> <v-icon>mdi-</v-icon> Add New</v-btn>

                <v-dialog v-model="dialog" persistent max-width="400px">
                <v-card id="modal">
                    <v-card-title>
                        <span id="modalTitle">{{ formTitle }}</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="py-0">
                    <v-container class="py-0">
                        <v-row>
                            <v-col cols="12" class="py-0">
                                <v-text-field v-model="editedItem.name" label="Name*" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-file-input v-model="editedItem.image" show-size label="File input"></v-file-input>
                            </v-col>
                        </v-row>
                    </v-container>
                    <!-- <small>*indicates required field</small> -->
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>

        <v-container>
            <v-row>
                <v-col>
                    <v-row>
                        <v-col md="8"></v-col>
                        <v-col md="4">
                            <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            solo
                            hide-details
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-data-table
                    :headers="headers"
                    :items="categories"
                    :search="search"
                    class="elevation-1"
                    >
                    <template v-slot:item.action="{ item }">
                        <td>
                        <v-btn 
                        icon 
                        color="success" 
                        @click="editItem(item)"
                        >
                             <v-icon>mdi-pencil-box</v-icon>
                        </v-btn>
                        <v-btn 
                        icon 
                        color="red"
                        @click="deleteItem(item)"
                        >
                             <v-icon>mdi-delete</v-icon>
                        </v-btn>
                        </td>
                    </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>

        <!-- <modal @close="endEditing" :product="editingItem" v-show="editingItem != null"></modal>
        <modal @close="addProduct"  :product="addingProduct" v-show="addingProduct != null"></modal> -->
        <br>
    </div>
</template>
<script>
    import Modal from './ProductModal'
	export default {
        data(){
            return {
                categories : [],
                editedItem: {
                    name: "",
                    image: null
                },
                defaultItem: {
                    name: "",
                    image: null
                },
                addingProduct : null,
                dialog: false,
                search: '',
                editedIndex: -1,
                headers: [
                {
                    text: 'Category Name',
                    align: 'start',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Action', value: 'action' },
                ],
            }
        },
        beforeMount(){
            axios.get('/api/categories')
            .then(response => {
                console.log(response.data)
                this.categories = response.data
            })
            .catch(error => {
                console.error(error);
            })     
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? "Add New Category" : "Edit Category";
            },
        },
        methods : {
            // endEditing(product){
            //     this.editingItem = null
            //     let index = this.products.indexOf(product)
            //     axios.put(`/api/products/${product.id}`,{
            //         name  : product.name,
            //         units : product.units,
            //         price : product.price,
            //         description : product.description,
            //     })
            //     .then(response =>{
            //         this.products[index] = product
            //     })
            //     .catch(response => {

            //     })
            // },
            // addProduct(product){
            //     this.addingProduct = null
            //     axios.post("/api/products/",{
            //         name  : product.name,
            //         units : product.units,
            //         price : product.price,
            //         description : product.description,
            //         image : product.image
            //     })
            //     .then(response =>{
            //         this.products.push(product)
            //     })
            //     .catch(response => {

            //     })
            // },
            editItem(item) {
                console.log(item);
                this.editedIndex = this.categories.indexOf(item);
                console.log(this.editedIndex);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },
            close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
            },
            async save(){
                if (this.editedIndex > -1) {
                    await axios.put("/api/categories/" + this.editedItem.id, this.editedItem)
                    .then(response => {
                      Object.assign(this.categories[this.editedIndex], this.editedItem);
                    })
                    .catch(response => { error })
                }
                else {
                    await axios.post("/api/categories", this.editedItem)
                    .then(response => {
                        console.log(response.data);
                        this.categories.push(response.data);
                    })
                    .catch(response => { error })
                }
                this.close();
            },
            async deleteItem(item) {
            const index = this.categories.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                this.categories.splice(index, 1);
                // this.$store.dispatch("deleteMedicine", item.id);
                await axios.delete("/api/categories/" + item.id)
                    .then(response => {
                        // console.log(response.data);
                        // this.categories.push(response.data);
                    })
                    .catch(response => { error })
            }
            },
        }
    }
</script>

<style scoped>
    
    #modal {
  font-family: "Ubuntu", sans-serif;
}

#modalTitle {
  font-size: 20px;
}
</style>