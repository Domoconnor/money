import axios from 'axios';

const state = {
	accounts: [],
	currentAccount: ''
}
const getters = {
	allAccounts: state => state.accounts,
	currentAccount: state => state.currentAccount
}

const mutations = {
	SET_ACCOUNTS(state, data) {
		state.accounts = data
		state.currentAccount = data[0]
	},

	ADD_ACCOUNT(state, account) {
		state.accounts.push(
			account
		)
	},

	DELETE_ACCOUNT(state, account) {
		state.accounts.splice(state.accounts.indexOf(account), 1)
	},

	EDIT_ACCOUNT(state, account) {
		state.accounts.find(p => p.id == account.id) == account;
	},

	CURRENT_ACCOUNT(state, account){
		state.currentAccount = state.accounts.find(p => p.id == account.id)
	}
}

const actions = {
	getAccounts({commit}){
		axios.get('/api/account')
		.then((response) => {
			commit('SET_ACCOUNTS', response.data.data);
		})
	},

	addAccount({commit}, account) {
		commit('ADD_ACCOUNT', account)
		axios.post('/api/account', {
			name: account.name
		})
	},

	deleteAccount({commit}, account) {
		commit('DELETE_ACCOUNT', account)
		axios.delete('/api/account/'+account.id)
	},

	 editAccount({commit}, account){
		commit('EDIT_ACCOUNT', account)
 		axios.put(`/api/account/${account.id}`, JSON.parse(JSON.stringify(account)))
	 },

	 setCurrentAccount({commit}, account){
		commit('CURRENT_ACCOUNT', account)
	 }
}


export default {
	state,
	getters,
	mutations,
	actions
}