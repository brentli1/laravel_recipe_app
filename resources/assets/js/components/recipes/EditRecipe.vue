<template>
	<v-layout>
		<v-flex xs12 sm10 offset-sm1>
			<div class="headline grey--text text--darken-1">Edit Recipe</div>
			<v-form v-model="valid" ref="form" xs10 enctype="multipart/form-data">
                <v-text-field
                    label="Title"
                    box
                    v-model="editableRecipe.title"
                    :rules="titleRules"
                    required
                ></v-text-field>
                <v-text-field
                    label="Description"
                    box
                    multi-line
                    v-model="editableRecipe.description"
                    :rules="descriptionRules"
                    required
                ></v-text-field>
                <v-text-field
                    label="Prep Time (mins)"
                    box
                    type="number"
                    v-model="editableRecipe.prep_time"
                    :rules="timeRules"
                    required
                ></v-text-field>
                <v-text-field
                    label="Cook Time (mins)"
                    box
                    type="number"
                    v-model="editableRecipe.cook_time"
                    :rules="timeRules"
                    required
                ></v-text-field>

				<div style="display:flex;">
					<div v-if="recipe.image">
						Current image
						<img :src="recipeImageUrl" alt="" style="max-width: 100%">
					</div>
					<input style="flex: 0 0 80%;" type="file" name="image" @change="updateImage">
				</div>
				

				<v-btn outline @click="$router.push(`/recipe/view/${recipe.id}`)">cancel</v-btn>
                <v-btn outline @click="updateAndRedirect()">save</v-btn>
            </v-form>
		</v-flex>
	</v-layout>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
	import { clone } from 'underscore';
	export default {
		data() {
			return {
				editableRecipe: {
					title: '',
					description: '',
					prep_time: '',
					cook_time: '',
					image: {}
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
			this.getActiveRecipe(this.id).then(() => {
				if (this.recipe == undefined) {
					this.$router.push('/');
				}

				this.editableRecipe = clone(this.recipe);
			});
		},
		props: {
			'id': ''
		},
		computed: {
			...mapGetters([
				'recipe'
			]),
			recipeImageUrl() {
				if (this.recipe.image !== undefined && this.recipe.image.length) {
					return `${s3}${this.recipe.image[0].path}`;
				}
			}
		},
		methods: {
			...mapActions([
				'getActiveRecipe',
				'updateActiveRecipe'
			]),
			updateAndRedirect() {
				this.updateActiveRecipe(this.editableRecipe).then(() => {
					this.$router.push(`/recipe/view/${this.recipe.id}`);
				});
			},
			updateImage(evt) {
				this.editableRecipe.image = evt.target.files[0];
			}
		}
	}
</script>
