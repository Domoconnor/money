<template>
	<div class="panel panel-default">
		<div class="panel-heading">Transactions</div>

		<div class="panel-body">
			<i @click="addTransaction" class="glyphicon glyphicon-plus"></i>
			<table v-if="allTransactions" class="table table-striped">
				<thead>
				<tr>
					<th>Name</th>
					<th>Amount</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<input type="text-area" v-model="form.name" class="form-control" @keyup.enter="addTransaction({form, currentAccount})">
					</td>
					<td>
						<input type="text-area" v-model="form.amount" class="form-control" @keyup.enter="addTransaction({form, currentAccount})">
					</td>
				</tr>
				<transaction  v-for="(transaction, key) in allTransactions" :transaction="transaction"></transaction>
				</tbody>
			</table>
			{{currentAccount}}
		</div>
	</div>
</template>

<script>
	import axios from 'axios';
	import { mapState, mapActions, mapGetters } from 'vuex'

	export default {

		data() {
			return {
				form: {
					name: '',
					amount: ''
				}
			}
		},

		mounted() {
			this.getTransactions();
		},

		computed: {
			...mapGetters(['allTransactions', 'currentAccount'])
		},

		methods: {
			updateTransaction(transaction, key) {
				axios.put('/api/transaction/' +  transaction.id, {
					transaction
				})
					.then((response) =>{
						console.log(response)
					})
			},

			...mapActions(['addTransaction', 'getTransactions']),
		}
	}
</script>
