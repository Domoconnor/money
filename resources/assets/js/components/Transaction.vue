<template>
	<tr>
		<td>
			<span v-if="!editing" @click="editable">{{transaction.name}}</span>
			<input v-if="editing" type="text-area" class="form-control"
				   @keyup.enter="updateName" @blur="editable" :value="transaction.name">
		</td>
		<td v-if="budget">
			<span v-if="!editing" @click="editable">{{budget.name}}</span>
			<select v-if="editing" @change="updateBudget">
				<option v-for="budget in allBudgets" :value="budget.id">{{budget.name}}</option>
			</select>
		</td>
		<td>
			<span v-if="!editing" @click="editable">{{transaction.amount}}</span>
			<input v-if="editing" type="text-area" class="form-control"
				   @keyup.enter="updateAmount" @blur="editable" :value="transaction.amount">
		</td>
		<td>
			<i class="fa fa-times" aria-hidden="true" @click="deleteTransaction(transaction)"></i>
		</td>
	</tr>
</template>

<script>

	import axios from 'axios';
	import { mapState, mapActions, mapGetters } from 'vuex'

	export default {
		props: ['transaction'],

		data() {
			return {
				editing: false
			}
		},

		computed: {
			...mapGetters(['allBudgets']),

			budget() {
				return this.allBudgets.find( budget => budget.id == this.transaction.budget_id)
			}
		},

		...mapState({
			transaction: state => state.transactions[transaction.id]
		}),

		methods: {
			...mapActions(['deleteTransaction']),

			updateAmount (e) {
				let transaction = this.transaction;
				transaction.amount =  e.target.value
				this.$store.dispatch("editTransaction", transaction)
			},

			updateName (e) {
				let transaction = this.transaction;
				transaction.name =  e.target.value
				this.$store.dispatch("editTransaction", transaction)
			},

			updateBudget(e){
				let transaction = this.transaction;
				transaction.budget_id =  parseInt(e.target.value)
				console.log(transaction)
				this.$store.dispatch("editTransaction", transaction)
			},

			editable (e) {
				this.editing = !this.editing;
			}
		}


	}
</script>
