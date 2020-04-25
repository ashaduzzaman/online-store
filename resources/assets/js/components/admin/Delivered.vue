<template>
    <div class="app">

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
                    >
                    <!-- <template v-slot:item.quantity="{ item }">
                        <v-chip color="primary" dark>{{ item.quantity }}</v-chip>
                    </template> -->
                    <template v-slot:item.price="{ item }">
                            <td>{{ item.quantity * item.product.price }}</td>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <td>
                        <v-btn
                        small
                        color="info"
                        >View</v-btn>
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
            axios.get('/api/delivered/')
            .then(response => {
                console.log(response.data)
                this.orders = response.data
            })
            .catch(error => {
                console.error(error);
            })     
        },
    
}
</script>