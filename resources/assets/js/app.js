import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import { store } from './store/store';

import Base from './components/Base.vue';
import MyRecipes from './components/recipes/MyRecipes.vue';
import NewRecipe from './components/recipes/NewRecipe.vue';
import EditRecipe from './components/recipes/EditRecipe.vue';
import ViewRecipe from './components/recipes/ViewRecipe.vue';

Vue.use(Vuex);
Vue.use(Vuetify);
Vue.use(VueRouter);

const routes = [
	{ path: '/', component: MyRecipes },
    { path: '/recipe/new', component: NewRecipe },
    { path: '/recipe/edit/:id', component: EditRecipe, props: true, name: 'recipeEdit' },
    { path: '/recipe/view/:id', component: ViewRecipe, props: true, name: 'recipeView' }
];

const router = new VueRouter({
	routes
});

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Base)
})
