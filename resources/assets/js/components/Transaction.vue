<template>
	<tr>
		<td>
			<span v-if="!editing" @click="editable">{{transaction.name}}</span>
			<input v-if="editing" type="text-area" class="form-control"
				   @keyup.enter="updateName" @blur="editable" :value="transaction.name">
		</td>
		<td>
			<span v-if="!editing" @click="editable">{{transaction.amount}}</span>
			<input v-if="editing" type="text-area" class="form-control"
				   @keyup.enter="updateAmount" @blur="editable" :value="transaction.amount">
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

		...mapState({
			transaction: state => state.transactions[transaction.id]
		}),

		methods: {
			updateAmount (e) {
				let transaction = this.transaction;
				transaction.amount =  e.target.value
				this.$store.dispatch("editTransaction", transaction)
			},

			updateName (e) {
				let transaction = this.transaction;
				transaction.name =  e.target.value
				console.log(transaction)
				this.$store.dispatch("editTransaction", transaction)
			},

			editable(e) {
				this.editing = !this.editing;
			}
		}


	}
</script>
