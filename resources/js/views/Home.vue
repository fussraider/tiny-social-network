<template>
    <b-container class="mb-5">
        <b-row>
            <b-card
                class="mb-3 w-100"
                no-body
                tag="article"
            >
                <b-card-header>About</b-card-header>

                <b-card-body>
                    Hi! This is an example of implementing a modest social network using the Laravel + Vue.JS stack.
                    The source code <a href="https://github.com/fussraider/tiny-social-network" target="_blank">here</a>.<br>

                    Here you can
                    <b-link to="/publish">publish</b-link>
                    your images or articles, as well as see materials from other users and put
                    likes.<br><br>


                    Enjoy!
                </b-card-body>

            </b-card>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: "Home",
    }
</script>

<style scoped>

</style>
