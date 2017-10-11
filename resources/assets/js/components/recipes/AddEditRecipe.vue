<template>
	<v-layout>
		<v-flex xs12 sm10 offset-sm1>
			<div class="headline grey--text text--darken-1">{{ pageTitle }}</div>
			<v-form v-model="valid" ref="form" xs10 enctype="multipart/form-data">
				<v-container grid-list-md>
					<v-layout row wrap>
						<v-flex xs12>
							<v-text-field
								label="Title"
								v-model="editableRecipe.title"
								:rules="titleRules"
								required
							></v-text-field>
						</v-flex>
						<v-flex xs12>
							<v-text-field
								label="Description"
								multi-line
								v-model="editableRecipe.description"
								:rules="descriptionRules"
								required
							></v-text-field>
						</v-flex>
						<v-flex xs12 sm6>
							<v-text-field
								label="Prep Time (mins)"
								type="number"
								v-model="editableRecipe.prep_time"
								:rules="timeRules"
								required
							></v-text-field>
						</v-flex>
						<v-flex xs12 sm6>
							<v-text-field
								label="Cook Time (mins)"
								type="number"
								v-model="editableRecipe.cook_time"
								:rules="timeRules"
								required
							></v-text-field>
						</v-flex>
						<v-flex xs12>
							<div style="display:flex;">
								<div v-if="recipe.image">
									Current image
									<img :src="recipeImageUrl" alt="" style="max-width: 100%">
								</div>
								<input style="flex: 0 0 80%;" type="file" name="image" @change="updateImage">
							</div>
						</v-flex>
						<v-flex xs12>
							<v-select
								v-model="editableRecipe.categories"
								label="Categories"
								chips
								multiple
								:items="categories"
							></v-select>
						</v-flex>
						<v-btn outline @click="cancelRedirect()">cancel</v-btn>
						<v-btn outline @click="saveAndRedirect()">save</v-btn>
					</v-layout>
				</v-container>
            </v-form>

			<v-dialog v-if="editableRecipe.id" v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
				<v-btn color="primary" dark slot="activator">Edit Recipe Steps</v-btn>
				<v-card>
					<v-toolbar dark color="primary">
						<v-btn icon @click.native="dialog = false" dark>
							<v-icon>close</v-icon>
						</v-btn>
						<v-toolbar-title>Edit Recipe Steps</v-toolbar-title>
						<v-spacer></v-spacer>
						<v-toolbar-items>
							<v-btn dark flat @click.native="dialog = false">Save</v-btn>
						</v-toolbar-items>
					</v-toolbar>
					<steps-list :recipeId="recipe.id" :steps="recipe.steps"></steps-list>
				</v-card>
			</v-dialog>
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
					image: {},
					categories: [],
					steps: []
				},
				dialog: false,
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
			/**
			 * If id prop exists, get active recipe, otherwise
			 * reset active recipe.
			 */
			if (this.id) {
				this.getActiveRecipe(this.id).then(() => {
					if (this.recipe == undefined) {
						this.$router.push('/');
					}

					this.editableRecipe = clone(this.recipe);
				});
			} else {
				this.resetActiveRecipe();
			}

			/**
			 * Fetch categories for dropdown list.
			 */
			this.fetchCategories();
		},
		props: {
			'id': ''
		},
		computed: {
			...mapGetters([
				'recipe',
				'categories'
			]),
			recipeImageUrl() {
				if (this.recipe.image !== undefined && this.recipe.image.length) {
					return `${s3}${this.recipe.image[0].path}`;
				}
			},
			pageTitle() {
				return this.id ? 'Edit Recipe' : 'Add New Recipe'
			}
		},
		methods: {
			...mapActions([
				'getActiveRecipe',
				'updateActiveRecipe',
				'addRecipe',
				'fetchCategories',
				'resetActiveRecipe'
			]),
			/**
			 * Save data and redirect page to recipe view
			 * 
			 * If id prop exists, update the recipe, otherwise save
			 * a new recipe
			 */
			saveAndRedirect() {
				if (this.id) {
					this.updateActiveRecipe(this.editableRecipe).then(() => {
						this.$router.push(`/recipe/view/${this.recipe.id}`);
					});
				} else {
					this.addRecipe(this.editableRecipe).then(() => {
						this.$router.push(`/recipe/view/${this.recipe.id}`);
					});
				}
			},
			updateImage(evt) {
				this.editableRecipe.image = evt.target.files[0];
			},
			cancelRedirect() {
				if (this.id) {
					this.$router.push(`/recipe/view/${this.recipe.id}`);
				} else {
					this.$router.push('/');
				}
			}
		}
	}
</script>
