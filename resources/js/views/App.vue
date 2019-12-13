<template>
    <div>
        <b-navbar type="dark" variant="success" class="mb-3">
            <b-container>

                <b-navbar-brand to="/">
                    <i class="fas fa-hand-spock"></i> N&P
                </b-navbar-brand>

                <b-navbar-nav class="ml-auto">
                    <template v-if="$auth.check()">
                        <b-nav-item to="/">Home</b-nav-item>
                        <b-nav-item to="/images">Images</b-nav-item>
                        <b-nav-item to="/articles">Articles</b-nav-item>
                        <b-nav-item to="/publish">
                            <i class="fas fa-plus-circle"></i>
                        </b-nav-item>
                    </template>
                </b-navbar-nav>

                <b-navbar-nav class="ml-auto">
                    <template v-if="$auth.check()">
                        <b-nav-text>{{ $store.getters.userName }}</b-nav-text>
                        <b-nav-item @click.prevent="userLogout">
                            <i class="fas fa-sign-out-alt"></i>
                        </b-nav-item>
                    </template>
                    <template v-else>
                        <b-nav-item to="/login">Login</b-nav-item>
                        <b-nav-item to="/register">Register</b-nav-item>
                    </template>
                </b-navbar-nav>
            </b-container>
        </b-navbar>

        <b-container>
            <b-row>
                <router-breadcrumbs class="w-100"></router-breadcrumbs>
            </b-row>
        </b-container>

        <router-view></router-view>

    </div>
</template>

<script>
    import RouterBreadcrumbs from '@/js/components/RouterBreadcrumbs';

    export default {
        name: "App",
        components: {RouterBreadcrumbs},
        data: () => {
            return {
                user: {}
            }
        },
        methods: {
            userLogout: function () {
                this.$auth.logout({
                    redirect: '/login',
                });
            }
        }
    }
</script>

<style scoped>

</style>
