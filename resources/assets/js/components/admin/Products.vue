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
                <tr v-for="(product,index) in products" :key="index" @dblclick="editingItem = product">
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
            <v-btn class="primary" flat depressed @click.stop="dialog = true"> <v-icon>mdi-</v-icon> Add New</v-btn>

                <v-dialog v-model="dialog" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                    <span class="headline">Add new product</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                    <v-container>
                        <v-row>
                        <v-col cols="12" class="py-0">
                            <v-text-field label="Name*" outlined required></v-text-field>
                        </v-col>
                        <v-col class="d-flex py-0" cols="12">
                            <v-select
                            :items="items"
                            label="Outlined style"
                            outlined
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6" class="py-0">
                            <v-text-field label="Unit(Stock)*" outlined required></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" class="py-0">
                            <v-text-field
                            label="Price*"
                            outlined
                            required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="py-0"> 
                            <v-textarea
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
                    <v-btn color="blue darken-1" text @click="dialog = false">Save</v-btn>
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
                        <v-btn icon color="success">
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
                products : [],
                editingItem : null,
                addingProduct : null,
                dialog: false,
                search: '',
                headers: [
                {
                    text: 'Name',
                    align: 'start',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Stock', value: 'units' },
                { text: 'Price', value: 'price' },
                { text: 'Description', value: 'description' },
                { text: 'Action', value: 'action' },
                ],
                items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
            }
        },
        components : {
            Modal
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
        },
        methods : {
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
                this.editingItem = null
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
            }
        }
    }
</script>