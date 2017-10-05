<template>
	<v-layout>
		<v-flex xs12 sm10 offset-sm1>
			<div class="headline grey--text text--darken-1">Add New Recipe</div>
			<v-form v-model="valid" ref="form" xs10>
                <v-text-field
                    label="Title"
                    box
                    v-model="recipe.title"
                    :rules="titleRules"
                    required
                ></v-text-field>
                <v-text-field
                    label="Description"
                    box
                    multi-line
                    v-model="recipe.description"
                    :rules="descriptionRules"
                    required
                ></v-text-field>
                <v-text-field
                    label="Prep Time (mins)"
                    box
                    type="number"
                    v-model="recipe.prep_time"
                    :rules="timeRules"
                    required
                ></v-text-field>
                <v-text-field
                    label="Cook Time (mins)"
                    box
                    type="number"
                    v-model="recipe.cook_time"
                    :rules="timeRules"
                    required
                ></v-text-field>
                <v-select
                    v-model="recipe.categories"
                    label="Categories"
                    chips
                    tags
                    :items="categories"
                ></v-select>
                <v-btn outline @click="$router.push(`/`)">cancel</v-btn>
                <v-btn outline @click="submit">save</v-btn>
            </v-form>
		</v-flex>
	</v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
    data() {
        return {
            recipe: {
                title: '',
                description: '',
                prep_time: '',
                cook_time: '',
                categories: []
            },
            valid: false,
            titleRules: [
                (v) => !!v || 'Title is required'
            ],
            descriptionRules: [
                (v) => !!v || 'Description is required'
            ],
            timeRules: [
                (v) => !!v || 'Time is required'
            ]
        }
    },
    created() {
        this.fetchCategories();  
    },
    methods: {
        ...mapActions([
            'fetchCategories'
        ]),
        submit() {
            this.$store.dispatch('addRecipe', this.recipe).then(() => {
                this.$router.push('/');
            });
        }
    },
    computed: {
        ...mapGetters([
            'categories'
        ])
    }
}
</script>
