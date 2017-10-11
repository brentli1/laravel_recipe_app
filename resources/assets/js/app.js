import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import { store } from './store/store';

import Base from './components/Base.vue';
import MyRecipes from './components/recipes/MyRecipes.vue';
import AddEditRecipe from './components/recipes/AddEditRecipe.vue';
import ViewRecipe from './components/recipes/ViewRecipe.vue';
import RedirectToForm from './components/recipes/RedirectToForm.vue';

import Steps from './components/steps/StepsList.vue';

Vue.use(Vuex);
Vue.use(Vuetify);
Vue.use(VueRouter);

Vue.component('steps-list', Steps);

const routes = [
    { path: '/', component: MyRecipes },
    { path: '/recipe/redirect', component: RedirectToForm },
    { path: '/recipe/new', component: AddEditRecipe, props: true },
    { path: '/recipe/edit/:id', component: AddEditRecipe, props: true, name: 'recipeEdit' },
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
