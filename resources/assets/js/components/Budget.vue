<template>
	<tr>
		<td>{{budget.name}}</td>
		<td>{{budgetTotal}}</td>

	</tr>
</template>

<script>

	import axios from 'axios';
	import { mapState, mapActions, mapGetters } from 'vuex'

	export default {
		props: ['budget'],

		data() {
			return {
			}
		},
		mounted() {
			this.getTransactions();
		},


		computed: {
			...mapGetters(['allTransactions']),

			budgetTotal() {
				let transactionTotal =  this.allTransactions.reduce((total, transaction) => transaction.budget_id == this.budget.id ? total + Number(transaction.amount) : total, 0);
				return this.budget.amount - transactionTotal;
			}
		},

		...mapState({
			budget: state => state.budgets[budget.id]
		}),

		methods: {
			...mapActions(['deleteBudget', 'getTransactions']),
		}


	}
</script>
