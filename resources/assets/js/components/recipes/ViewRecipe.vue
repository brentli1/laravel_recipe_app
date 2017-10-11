<template>
    <v-layout>
        <v-flex xs12 sm10 offset-sm1>
            <v-card>
                <v-card-media v-if="recipe.image && recipe.image.length" :src="imageUrl" height="400px"></v-card-media>
                <v-card-title>
                    <div class="headline grey--text">{{ recipe.title }}</div>
                </v-card-title>
                <v-card-text>
                    <div class="mb-3">{{ recipe.description }}</div>
                    <div>{{ prepTime }}</div>
                    <div>{{ cookTime }}</div>
                    <v-divider class="mb-2 mt-2"></v-divider>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat @click="$router.push(`/`)">view all</v-btn>
                    <v-btn flat @click="$router.push(`/recipe/edit/${recipe.id}`)">edit</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    export default {
        created() {
            this.getActiveRecipe(this.id);
        },
        props: {
            'id': ''
        },
        computed: {
            ...mapGetters([
                'recipe'
            ]),
            prepTime() {
                return `Prep Time: ${this.recipe.prep_time} minutes`;
            },
            cookTime() {
                return `Cook Time: ${this.recipe.cook_time} minutes`;
            },
            imageUrl() {
                if (this.recipe.image !== undefined && this.recipe.image.length) {
                    return `${s3}${this.recipe.image[0].path}`;
                }
            }
        },
        methods: {
            ...mapActions([
                'getActiveRecipe'
            ])
        }
    }
</script>
