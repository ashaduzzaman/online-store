<template>
	<div>
        <!-- <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <td></td>
                    <td>Product</td>
                    <td>Quantity</td>
                    <td>Cost</td>
                    <td>Delivery Address</td>
                    <td>is Delivered?</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order,index) in orders" @key="index">
                    <td>{{index+1}}</td>
                    <td v-html="order.product.name"></td>
                    <td>{{order.quantity}}</td>
                    <td>{{order.quantity * order.product.price}}</td>
                    <td>{{order.address}}</td>
                    <td>{{order.is_delivered == 1? "Yes" : "No"}}</td>
                    <td v-if="order.is_delivered == 0"><button class="btn btn-success" @click="deliver(index)">Deliver</button></td>
                </tr>
            </tbody>
        </table> -->
        <v-container>
            <v-row>
                <v-col>
                    <v-row>
                        <v-col md="6"></v-col>
                        <v-col md="6">
                            <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-data-table
                    :headers="headers"
                    :items="orders"
                    :search="search"
                    class="elevation-1"
                    >
                    <template v-slot:item.quantity="{ item }">
                        <v-chip color="primary" dark>{{ item.quantity }}</v-chip>
                    </template>
                    <template v-slot:item.price="{ item }">
                            <td>{{ item.quantity * item.product.price }}</td>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <td>
                        <v-btn
                        small
                        color="success"
                        @click=deliver(item)
                        >Deliver</v-btn>
                        </td>
                    </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>

    </div>
</template>
<script>
	export default {
        data(){
            return {
                orders : [],
                search: '',
                headers: [
                {
                    text: 'Product',
                    align: 'start',
                    sortable: false,
                    value: 'product.name',
                },
                { text: 'Quantity', value: 'quantity' },
                { text: 'Total Cost', value: 'price' },
                { text: 'Delivery Address', value: 'address' },
                { text: 'Action', value: 'action' },
                ],
            }
        },
        beforeMount(){
            axios.get('/api/orders/')
            .then(response => {
                this.orders = response.data
            })
            .catch(error => {
                console.error(error);
            })     
        },
        methods : {
            deliver(item){
                // let order = this.orders[item]
                axios.patch(`/api/orders/${item.id}/deliver`)
                .then(response => {
                    this.orders = response.data.data  
                    // this.orders[item].is_delivered = 1
                    // this.$forceUpdate()
                })
                .catch(error => {
                    console.error(error);
                })   
            }
        }
    }
</script>