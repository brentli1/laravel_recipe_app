<template>
    <v-container fluid class="pr-2 pl-2">
        <v-layout>
            <v-flex xs12 sm10 offset-sm1>
                hello from the inside {{recipeId}}
                <ul>
                    <li v-for="step in editableSteps" :key="step.id">
                        step body: {{ step.body }}
                    </li>
                </ul>
                <v-btn v-show="!isAdding" outline @click="addNewStep">Add New Step</v-btn>
                <v-form v-show="isAdding">
                    <div class="headline grey--text text--darken-1">Add New Step</div>
                    <v-container grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-text-field
                                    label="Step Details"
                                    v-model="stepAdding.body"
                                    multi-line
                                    required
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <div style="display:flex;">
                                    <input style="flex: 1;" type="file" name="image" @change="updateImage">
                                </div>
                            </v-flex>
                            <v-btn outline @click="cancelStepAdd">Cancel</v-btn>
                            <v-btn outline @click="saveNewStep">Save</v-btn>
                        </v-layout>
                    </v-container>
                </v-form>
            </v-flex>
        </v-layout> 
    </v-container>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    data() {
        return {
            editableSteps: [],
            stepAdding: {
                id: '',
                body: '',
                order: '',
                image: {}
            },
            isAdding: false
        }
    },
    created() {
        this.editableSteps = this.steps;
    },
    props: {
        'recipeId': '',
        'steps': ''
    },
    methods: {
        ...mapActions([
            'createStep',
            'syncActiveRecipeChanges'
        ]),
        addNewStep() {
            this.isAdding = true;
        },
        cancelStepAdd() {
            this.stepAdding = { body: '', order: '', image: {} };
            this.isAdding = false;
        },
        /**
         * Save new step and force update of editableSteps data
         */
        saveNewStep() {
            this.stepAdding.id = this.recipeId;
            this.createStep(this.stepAdding).then((data) => {
                this.syncActiveRecipeChanges(data).then(() => {
                    this.editableSteps = this.steps;
                    this.isAdding = false;
                    this.stepAdding = { body: '', order: '' };
                });
            });
        },
        updateImage(evt) {
            this.stepAdding.image = evt.target.files[0];
        }
    }
}
</script>
