const state = {
    categories: []
};

const getters = {
	categories: state => {
		return state.categories;
    }
};

const mutations = {
    setCategories: (state, payload) => {
        state.categories = payload;
    }
};

const actions = {
    fetchCategories: ({ commit, state }) => {
        if (!state.categories.length) {
            axios.get(`/api/categories`)
                .then(({ data }) => {
                    commit('setCategories', data.data);
                });
        }
    }
};

export default {
	state,
	getters,
	mutations,
	actions
}
