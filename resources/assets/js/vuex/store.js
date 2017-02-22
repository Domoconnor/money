// store.js

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
import transactions from './modules/transactions';
import accounts from './modules/accounts'
export default new Vuex.Store({

	modules: {
		transactions,
		accounts,
	}

})