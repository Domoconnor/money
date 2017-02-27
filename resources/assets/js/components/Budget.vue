<template>
	<tr>
		<td>{{budget.name}}</td>
		<td>{{budget.amount}}</td>

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

		...mapState({
			budget: state => state.budgets[budget.id]
		}),

		methods: {
			...mapActions(['deleteBudget']),
		}


	}
</script>
