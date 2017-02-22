<template>
	<div class="panel panel-default">
		<div class="panel-heading">Accounts</div>

		<div class="panel-body">
			<account v-if="allAccounts" v-for="account in allAccounts" :account="account"></account>
			<input type="text-area" class="form-control"
				   @keyup.enter="addAccount(createForm)" v-model="createForm.name">
		</div>
	</div>
</template>

<script>
	import axios from 'axios';
	import { mapState, mapActions, mapGetters } from 'vuex'

	export default {
		data() {
			return {
				createForm: {
					accountName: ''
				},
			}
		},

		mounted() {
			this.getAccounts();

		},

		computed: {
			...mapGetters(['allAccounts']),
		},

		methods: {
			...mapActions(['getAccounts', 'addAccount']),
		}
	}
</script>

