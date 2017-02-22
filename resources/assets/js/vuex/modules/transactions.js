import axios from 'axios';

const state = {
	transactions: []
}

const getters = {
	allTransactions: state => state.transactions
}

const mutations = {
	ADD_TRANSACTION(state, {name, amount}) {

		state.transactions.push({
			name,
			amount
		})
	},

	SET_TRANSACTIONS(state, stuff) {
		state.transactions = stuff;
	},

	EDIT_TRANSACTION(state, transaction) {
		state.transactions.find(p => p.id == transaction.id) == transaction;
	}
}

const actions =  {
	addTransaction({commit}, {form: transaction, currentAccount: account}){
		commit('ADD_TRANSACTION', transaction)
		axios.post(`/api/account/${account.id}/transaction`, transaction)
	},

	getTransactions({commit}) {
		axios.get('/api/transaction')
			.then((response) => {
				commit('SET_TRANSACTIONS', response.data.data);
			})
	},

	editTransaction({commit}, transaction) {
		commit('EDIT_TRANSACTION', transaction)
		axios.put(`/api/transaction/${transaction.id}`, transaction)
	}

	// postTransactions({commit}) {
	// 	axios.post('/api/account/${asd}/transaction/'  {
	// 		transaction
	// 	})
	// 		.then((response) =>{
	// 			console.log(response)
	// 		})
	// }


}

export default {
	state,
	getters,
	mutations,
	actions
}