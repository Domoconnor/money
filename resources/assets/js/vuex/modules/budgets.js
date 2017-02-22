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
		axios.get('/api/budget')
			.then((response) => {
				commit('SET_BUDGETS', response.data.data);
			})
	},

	addAccount({commit}, budget) {
		commit('ADD_BUDGET', budget)
		axios.post('/api/budget', {
			name: budget.name
		})
	},

	deleteAccount({commit}, budget) {
		commit('DELETE_BUDGET', budget)
		axios.delete('/api/budget/'+budget.id)
	},

	editAccount({commit}, budget){
		commit('EDIT_BUDGET', budget)
		axios.put(`/api/budget/${budget.id}`, JSON.parse(JSON.stringify(budget)))
	},

	setCurrentAccount({commit}, budget){
		commit('CURRENT_BUDGET', budget)
	}
}


export default {
	state,
	getters,
	mutations,
	actions
}