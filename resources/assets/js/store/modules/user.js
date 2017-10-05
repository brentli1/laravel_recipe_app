const state = {
	user: []
};

const getters = {
	user: state => {
		return state.user;
	}
};

const mutations = {
	fetchUser: (state, payload) => {
		state.user = payload
	}
};

const actions = {
	fetchUser: ({ commit }) => {
		if (!state.user.length) {
            axios.get('/api/user')
				.then(({ data }) => {
					commit('fetchUser', data.data)
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
