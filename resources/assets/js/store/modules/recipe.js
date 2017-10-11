import { extend, findWhere, pluck } from 'underscore';

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
    /**
     * Add new recipe
     */
	addRecipe: ({ commit }, payload) => {
        return new Promise((resolve, reject) => {
            let data = new FormData();
            data.set('image', payload.image);
            data.set('title', payload.title);
            data.set('description', payload.description);
            data.set('prep_time', payload.prep_time);
            data.set('cook_time', payload.cook_time);
            data.set('categories', JSON.stringify(payload.categories));

            axios.post('/api/recipe/new', data)
            .then(({ data }) => {
                commit('addRecipe', data.data);
                commit('setActiveRecipe', data.data);
                resolve(data.data);
            });
        });
    },
    /**
     * Fetch the recipes collection
     * 
     * If recipes have already been fetched, don't perform
     * this action.
     */
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
    /**
     * Get the active recipe
     * 
     * If recipes has already been fetch, look through collection
     * for desired recipe to show.  If no recipes have been fetched,
     * hit the database to retrieve the recipe.
     */
    getActiveRecipe: ({ commit, state }, payload) => {
            if (state.recipe.id !== Number.parseInt(payload)) {
                return new Promise((resolve, reject) => {
                    if (state.recipes.length) {
                        commit('setActiveRecipe', findWhere(state.recipes, {'id': parseInt(payload)}));
                        resolve();
                    } else {
                        axios.get(`/api/recipe/${payload}`)
                            .then(({ data }) => {
                                if (data.data == undefined) {
                                    resolve();
                                }
                                
                                commit('setActiveRecipe', data.data);
                                resolve(data.data);
                            });
                    }
                });
            } else {
                return new Promise((resolve) => {
                    resolve();
                });
            }
    },
    /**
     * Update the active recipe
     */
    updateActiveRecipe: ({ commit, state }, payload) => {
        return new Promise((resolve, reject) => {
            let data = new FormData();
            data.set('image', payload.image);
            data.set('title', payload.title);
            data.set('description', payload.description);
            data.set('prep_time', payload.prep_time);
            data.set('cook_time', payload.cook_time);
            data.set('id', payload.id);
            data.set('categories', JSON.stringify(payload.categories));

            axios.post(`/api/recipe/edit/${payload.id}`, data)
                .then(({ data }) => {
                    commit('setActiveRecipe', data.data);

                    // Manually update recipes collection
                    extend(findWhere(state.recipes, {'id': data.data.id}), data.data);
                    resolve(data.data);
                });
        });
    },
    /**
     * Reset the active recipe to an empty array. This is needed for 
     * when visiting the create new recipe route.
     */
    resetActiveRecipe({ commit }) {
        commit('setActiveRecipe', []);
    },
    /**
     * Update a recipe within the recipes collection and active recipe
     */
    syncActiveRecipeChanges({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            extend(findWhere(state.recipes, {'id': payload.id}), payload);

            commit('setActiveRecipe', payload);
            resolve();
        });
    }
};

export default {
	state,
	getters,
	mutations,
	actions
}
