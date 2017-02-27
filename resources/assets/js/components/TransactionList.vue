<template>
	<div class="panel panel-default">
		<div class="panel-heading">Transactions</div>

		<div class="panel-body">
			<i @click="addTransaction" class="glyphicon glyphicon-plus"></i>
			<table v-if="allTransactions" class="table table-striped">
				<thead>
				<tr>
					<th>Name</th>
					<th>Budget</th>
					<th>Amount</th>
					<th>Delete</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<input type="text-area" v-model="form.name" class="form-control" @keyup.enter="addTransaction({form, currentAccount})">
					</td>
					<td>
						<select v-model="form.budget">
							<option v-for="budget in allBudgets" v-bind:value="budget.id">{{budget.name}}</option>
						</select>
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
					budget: {
						id: ''
					},
					amount: ''
				}
			}
		},

		mounted() {
			this.getTransactions();
			this.getBudgets();
		},

		computed: {
			...mapGetters(['allTransactions', 'currentAccount', 'allBudgets'])
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

			...mapActions(['addTransaction', 'getTransactions', 'getBudgets']),
		}
	}
</script>
