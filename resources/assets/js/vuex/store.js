// store.js

import Vue from 'vue'
import Vuex from 'vuex'
import budgets from './modules/budgets';
import accounts from './modules/accounts';
import transactions from './modules/transactions';

Vue.use(Vuex);
export default new Vuex.Store({

	modules: {
		transactions,
		accounts,
		budgets
	}

})