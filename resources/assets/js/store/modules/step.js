const state = {

};

const getters = {

};

const mutations = {

};

const actions = {
    createStep: ({ commit, state }, payload) => {
        return new Promise((resolve, reject) => {
            let data = new FormData();
            data.set('body', payload.body);
            data.set('image', payload.image);

            axios.post(`/api/steps/new/${payload.id}`, data)
                .then(({ data }) => {
                    resolve(data.data);
                });
        });
    }
};

export default {
	state,
	getters,
	mutations,
	actions
}
