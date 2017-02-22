import axios from 'axios';

const state = {
	budgets: [],
}
const getters = {
	allBudgets: state => state.budgets,
}

const mutations = {
	SET_BUDGETS(state, data) {
		state.budgets = data
	},

	ADD_BUDGET(state, budget) {
		state.budgets.push(
			budget
		)
	},

	DELETE_BUDGET(state, budget) {
		state.budgets.splice(state.budgets.indexOf(budget), 1)
	},

	EDIT_BUDGET(state, budget) {
		state.budgets.find(p => p.id == budget.id) == budget;
	},
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