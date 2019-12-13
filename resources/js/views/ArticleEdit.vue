<template>
    <b-container>
        <b-row>
            <article-form
                :article_id="$route.params.id"
            ></article-form>
        </b-row>
    </b-container>
</template>

<script>
    import ArticleForm from "../components/ArticleForm";

    export default {
        name: "Publish",
        components: {ArticleForm},
        data: () => {
            return {
                article: {},
            }
        },

        mounted: function () {
        },

        methods: {}
    }
</script>

<style scoped>

</style>
