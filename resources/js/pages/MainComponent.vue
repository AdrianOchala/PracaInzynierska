<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            dark
            app
            clipped
        >
            <v-list class="text-decoration-none">
                <v-list-item :to="{path: '/'}">
                    <v-list-item-content>
                        <v-list-item-title>Strona główna</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-for="(menuItem, index) in permission" :key="index" v-if="permission.length && menuItem.read" exact
                             :to="{path: '/'+menuItem.name}">
                    <v-list-item-content>
                        <v-list-item-title> {{ menuItem.resourceName}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
<!--                <v-list-item :to="{path: 'searchMechanic'}">-->
<!--                    <v-list-item-content>-->
<!--                        <v-list-item-title>Wyszukaj mechanika</v-list-item-title>-->
<!--                    </v-list-item-content>-->
<!--                </v-list-item>-->
<!--                <v-list-item :to="{path: 'AdminRole'}">-->
<!--                    <v-list-item-content>-->
<!--                        <v-list-item-title>Dodaj rolę</v-list-item-title>-->
<!--                    </v-list-item-content>-->
<!--                </v-list-item>-->
<!--                <v-list-item :to="{path: 'AdminRoleManagement'}">-->
<!--                    <v-list-item-content>-->
<!--                        <v-list-item-title>Zarządzaj rolami</v-list-item-title>-->
<!--                    </v-list-item-content>-->
<!--                </v-list-item>-->

                <v-divider></v-divider>
                <v-list-item href="/logout">
                    <v-list-item-content>
                        <v-list-item-title>Wyloguj</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            app
            dark
            clipped-left
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Menu</v-toolbar-title>
            <v-spacer></v-spacer>
            <h2>AutoService24</h2>
            <v-spacer></v-spacer>
            Zalogowany jako:{{this.user.name}} {{this.user.surname}}
            <a href="/logout" class="text-decoration-none">Wyloguj </a>
        </v-app-bar>
        <v-main>
            <v-content style="padding: 20px 20px 10px 20px;">
                <router-view></router-view>
            </v-content>
        </v-main>
        <v-footer
            app
            dark
            class="white--text"
        >
            <span>AutoService24</span>
            <v-spacer></v-spacer>
            <span>Adrian Ochała &copy; {{ new Date().getFullYear() }}</span>
        </v-footer>
    </v-app>


</template>

<script>
    export default {
        props: ['user','permission'],
        name: "MainComponent",
        data(){
            return{
                drawer: null,
        }},
        computed: {

        },
        created(){
            this.$store.commit('updateUser', this.user);
            this.$store.commit('updateUserPermission', this.permission);

        },
        methods: {

        },
    }
</script>
