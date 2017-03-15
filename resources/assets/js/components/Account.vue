<template>
	<div @click="setCurrentAccount(account)">
		{{account.name}} <div class="pull-right"><i v-if="account == currentAccount"class="fa fa-star" aria-hidden="true"></i><i class="fa fa-times" aria-hidden="true" @click="deleteAccount(account)"></i></div>
		£{{sum}}
	</div>
</template>

<script>
import axios from 'axios';
import { mapState, mapActions, mapGetters } from 'vuex'

    export default {
		props: ['account'],

    	data() {
    		return {
            }
        },

        mounted() {

        },

        computed: {
            ...mapGetters(['allAccounts', 'currentAccount', 'allTransactions']),

			sum() {
				return this.allTransactions.reduce((acc, val) => val.account_id == this.account.id ? acc + Number(val.amount) : acc, 0)
			}
        },

        methods: {
            ...mapActions(['getAccounts', 'addAccount', 'deleteAccount', 'setCurrentAccount']),

            editAccount(account) {
 			account.name = this.createForm.name;

			this.$store.dispatch("editAccount", account)
            }
        }
    }
</script>
