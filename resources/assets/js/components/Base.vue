<template>
    <v-app toolbar>
        <v-navigation-drawer
            persistent
            light
            clipped
            enable-resize-watcher
            v-model="drawer"
        >
            <v-list dense>
                <v-list-tile @click="navigateTo('/')">
                    <v-list-tile-action>
                        <v-icon>event_note</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>My Recipes</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="navigateTo('/recipe/new')">
                    <v-list-tile-action>
                        <v-icon>add_box</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Add New Recipe</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
            <v-divider></v-divider>
            <v-list dense>
                <v-list-tile @click="logout">
                    <v-list-tile-action>
                        <v-icon>exit_to_app</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar class="white" light fixed>
            <v-toolbar-side-icon class="orange--text text--darken-3" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title class="brown--text text--darken-4">Toolbar</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu offset-y v-show="user.name">
                <v-btn flat class="orange--text text--darken-3" slot="activator">Hi {{ user.name }}.<v-icon right dark>face</v-icon></v-btn>
                <v-list>
                    <v-list-tile @click="logout">
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
        <main>
            <v-container fluid class="pr-2 pl-2">
                <router-view></router-view>
            </v-container>
        </main>
    </v-app>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        data() {
            return {
                drawer: ''
            }
        },
        created() {
            this.$store.dispatch('fetchUser');
        },
        methods: {
            logout() {
                axios.post('/logout')
                    .then(function() {
                        window.location.href="/";
                    });
            },
            navigateTo(path) {
                this.$router.push(path);
            }
        },
        computed: {
            ...mapGetters([
                'user'
            ])
        }
    }
</script>
