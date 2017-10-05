import Vue from 'vue';
import Vuex from 'vuex';

import user from './modules/user';
import recipe from './modules/recipe';
import category from './modules/category';

Vue.use(Vuex);

export const store = new Vuex.Store({
	modules: {
		user,
		recipe,
		category
	}
});
