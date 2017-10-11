<template>
    <v-flex xs12 sm10 offset-sm1>
        <h1 class="headline grey--text text--darken-1">My Recipes</h1>
        <v-container fluid grid-list-lg class="pr-0 pl-0">
            <v-layout row wrap>
                <v-flex xs12 sm6 md4 v-for="recipe in recipes" :key="recipe.id">
                    <v-card height="100%">
                        <v-card-media v-if="recipe.image.length" :src="recipeImageUrl(recipe)" height="200px"></v-card-media>
                        <v-card-title primary-title>
                            <h5 class="headline mb-0">{{ recipe.title }}</h5>
                        </v-card-title>
                        <v-card-actions>
                            <v-btn flat class="brown--text" @click="navigateTo(`/recipe/edit/${recipe.id}`)">Edit</v-btn>
                            <v-btn flat class="brown--text" @click="navigateTo(`/recipe/view/${recipe.id}`)">View</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-flex>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        created() {
            this.$store.dispatch('fetchRecipes');
        },
        computed: {
            ...mapGetters([
                'recipes'
            ])
        },
        methods: {
            navigateTo(path) {
                this.$router.push(path);
            },
            recipeImageUrl(recipe) {
                return `${s3}${recipe.image[0].path}`;
            }
        }
    }
</script>
