<template>
	<table v-if="allBudgets" class="table table-striped">
		<thead>
		<tr>
			<th>Name</th>
			<th>Amount</th>
			<th>Delete</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>
				<input type="text-area" v-model="form.name" class="form-control" @keyup.enter="addBudget(form)">
			</td>
			<td>
				<input type="text-area" v-model="form.amount" class="form-control" @keyup.enter="addBudget(form)">
			</td>
		</tr>
		<budget v-for="(budget, key) in allBudgets" :budget="budget"></budget>
		</tbody>
	</table>
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
			this.getBudgets();
		},

		computed: {
			...mapGetters(['allBudgets']),
		},

		methods: {
			...mapActions(['addBudget', 'getBudgets']),
		}
	}
</script>
