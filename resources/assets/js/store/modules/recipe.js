import { extend, findWhere } from 'underscore';

const state = {
    recipe: {},
    recipes: []
};

const getters = {
	recipe: state => {
		return state.recipe;
    },
    recipes: state => {
        return state.recipes;
    }
};

const mutations = {
    addRecipe: (state, payload) => {
        state.recipes.unshift(payload);
    },
    fetchRecipes: (state, payload) => {
        state.recipes = payload;
    },
    setActiveRecipe: (state, payload) => {
        state.recipe = payload;
    },
    resetActiveRecipe: (state) => {
        state.recipe = {};
    }
};

const actions = {
	addRecipe: ({ commit }, payload) => {
        axios.post('/api/recipe/new', payload)
            .then(({ data }) => {
                commit('addRecipe', data.data);
            });
    },
    fetchRecipes: ({ commit, state }) => {
        if (!state.recipes.length) {
            return new Promise((resolve, reject) => {
                axios.get('/api/recipe/all')
                    .then(({ data }) => {
                        commit('fetchRecipes', data.data);
                        resolve(data.data);
                    });
                });
        }
    },
    getActiveRecipe: ({ commit, state }, payload) => {
        if (state.recipe.id !== Number.parseInt(payload)) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/recipe/${payload}`)
                    .then(({ data }) => {
                        if (data.data == undefined) {
                            resolve();
                        }
                        
                        commit('setActiveRecipe', data.data);
                        resolve(data.data);
                    });
            });
        } else {
            return new Promise((resolve) => {
                resolve();
            });
        }
    },
    updateActiveRecipe: ({ commit, state }, payload) => {
        return new Promise((resolve, reject) => {
            
            let data = new FormData();
            data.set('image', payload.image);
            data.set('title', payload.title);
            data.set('description', payload.description);
            data.set('prep_time', payload.prep_time);
            data.set('cook_time', payload.cook_time);
            data.set('id', payload.id);

            axios.post(`/api/recipe/edit/${payload.id}`, data)
                .then(({ data }) => {
                    commit('setActiveRecipe', data.data);

                    // Manually update recipes collection
                    extend(findWhere(state.recipes, {'id': data.data.id}), data.data);

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
