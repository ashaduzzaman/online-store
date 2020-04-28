<template>
	<div>
        <!-- <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <td></td>
                    <td>Product</td>
                    <td>Units</td>
                    <td>Price</td>
                    <td>Description</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product,index) in products" :key="index" @dblclick="editedItem = product">
                    <td>{{index+1}}</td>
                    <td v-html="product.name"></td>
                    <td v-model="product.units">{{product.units}}</td>
                    <td v-model="product.price">{{product.price}}</td>
                    <td v-model="product.price">{{product.description}}</td>
                </tr>
            </tbody>
        </table> -->
        
        <v-toolbar flat color="white" class="mt-6">
            <v-toolbar-title class="grey--text">Product List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
        <!-- <button class="btn btn-primary" @click="newProduct">Add New Product</button> -->
            <v-btn class="primary" text depressed @click.stop="dialog = true"> <v-icon>mdi-</v-icon> Add New</v-btn>

                <v-dialog v-model="dialog" persistent max-width="600px">
                <v-card id="modal">
                    <v-card-title>
                        <span id="modalTitle">{{ formTitle }}</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                    <v-container>
                        <v-row>
                        <v-col cols="12" class="py-0">
                            <v-text-field v-model="editedItem.name" label="Name*" outlined required></v-text-field>
                        </v-col>
                        <v-col class="d-flex py-0" cols="12">
                            <v-select
                            v-model="editedItem.category_id"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            label="Select Category"
                            outlined
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" class="py-0">
                            <v-text-field 
                            v-model="editedItem.units"
                            type="number"
                            label="Unit(Stock)*"
                            outlined 
                            required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" class="py-0">
                            <v-text-field
                            v-model="editedItem.price"
                            type="number"
                            label="Price*"
                            outlined
                            required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="py-0"> 
                            <v-textarea
                                v-model="editedItem.description"
                                outlined
                                label="Description"
                                hint="Description of the product"
                                height="5"
                            ></v-textarea>
                        </v-col>
                        </v-row>
                    </v-container>
                    <!-- <small>*indicates required field</small> -->
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
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
                    :items="products"
                    :search="search"
                    class="elevation-1"
                    >
                    <template v-slot:item.quantity="{ item }">
                        <v-chip color="primary" dark>{{ item.units }}</v-chip>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <td>
                        <v-btn icon color="success" @click="editItem(item)">
                             <v-icon>mdi-pencil-box</v-icon>
                        </v-btn>
                        <v-btn icon color="red">
                             <v-icon>mdi-delete</v-icon>
                        </v-btn>
                        </td>
                    </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>

        <!-- <modal @close="endEditing" :product="editedItem" v-show="editedItem != null"></modal>
        <modal @close="addProduct"  :product="addingProduct" v-show="addingProduct != null"></modal> -->
        <br>
    </div>
</template>
<script>
    import Modal from './ProductModal'
	export default {
        data(){
            return {
                products : [],
                categories: [],
                editedItem : {
                    name: "",
                    units: null,
                    price: null,
                    category_id: null,
                    description: ""
                },
                defaultItem: {
                    name: "",
                    units: null,
                    price: null,
                    category_id: null,
                    description: ""
                },
                addingProduct : null,
                dialog: false,
                editedIndex: -1,
                search: '',
                headers: [
                {
                    text: 'Name',
                    align: 'start',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Category', value: 'category' },
                { text: 'Stock', value: 'units' },
                { text: 'Price', value: 'price' },
                { text: 'Description', value: 'description' },
                { text: 'Action', value: 'action' },
                ],
                items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
            }
        },
        computed: {
            formTitle() {
                return this.editedIndex === -1 ? "Add New Product" : "Edit Product";
            },
        },
        beforeMount(){
            axios.get('/api/products/')
            .then(response => {
                console.log(response.data)
                this.products = response.data
            })
            .catch(error => {
                console.error(error);
            })
            this.getCategory()
        },
        methods : {
            getCategory(){
                axios.get('/api/categories')
                .then(response => {
                    console.log(response.data)
                    this.categories = response.data
                })
                .catch(error => {
                    console.error(error);
                })
            },
            newProduct(){
                this.addingProduct = {
                    name : null, 
                    units : null, 
                    price : null,
                    description : null,
                    image : null
                }
            },
            endEditing(product){
                this.editedItem = null
                let index = this.products.indexOf(product)
                axios.put(`/api/products/${product.id}`,{
                    name  : product.name,
                    units : product.units,
                    price : product.price,
                    description : product.description,
                })
                .then(response =>{
                    this.products[index] = product
                })
                .catch(response => {

                })
            },
            addProduct(product){
                this.addingProduct = null
                axios.post("/api/products/",{
                    name  : product.name,
                    units : product.units,
                    price : product.price,
                    description : product.description,
                    image : product.image
                })
                .then(response =>{
                    this.products.push(product)
                })
                .catch(response => {

                })
            },
            editItem(item) {
                console.log(item);
                this.editedIndex = this.products.indexOf(item);
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
                    await axios.put("/api/products/" + this.editedItem.id, this.editedItem)
                    .then(response => {
                      Object.assign(this.products[this.editedIndex], this.editedItem);
                    })
                    .catch(response => { error })
                }
                else {
                    console.log(this.editedItem);
                    await axios.post("/api/products", this.editedItem)
                    .then(response => {
                        console.log(response.data);
                        this.products.push(response.data.data);
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