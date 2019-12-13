<template>
    <b-container class="mb-5">
        <b-row>

            <b-alert
                class="w-100"
                v-if="articles == null"
                variant="info"
                show
            >
                <i class="fas fa-spinner fa-spin"></i> Loading articles...
            </b-alert>

            <template v-else-if="typeof articles.data != 'undefined' && articles.total > 0">
                <b-card-group columns>
                    <template v-for="article in (articles.data || [])">
                        <article-entity
                            :title="article.title"
                            :body="article.body"
                            :url="'/article/' + article.id"
                            :data_id="article.id"
                            :owner="article.owner"
                            :created_at="article.created_at"
                            :likes="article.likes.length"
                            thumb="true"
                        ></article-entity>
                    </template>
                </b-card-group>

                <b-pagination
                    v-if="typeof articles != 'undefined' || articles.last_page > 1"
                    v-model="articles.current_page"
                    :total-rows="articles.total"
                    :per-page="articles.per_page"
                    aria-controls="my-table"
                    @input="goPage"
                ></b-pagination>
            </template>
            <b-col
                v-else
                cols="12"
                class="text-center"
            >
                <i class="fas fa-info-circle fa-3x"></i><br/>
                <span class="h2">No one has posted news yet.</span>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import ArticleEntity from "../components/ArticleEntity";

    export default {
        name: "Articles",
        components: {ArticleEntity},
        data: () => {
            return {
                articles: null
            }
        },

        mounted: function () {
            this.getArticles();
        },

        methods: {
            getArticles: function () {
                this.articles = null;

                this.$http.get('article_list', {
                    params: {
                        page: this.$route.params.page || 1
                    }
                })
                    .then(response => {
                        if (response.data.result) {
                            this.articles = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },

            goPage(page){
                this.$router.push('/articles/' + page);
            }
        },

        watch: {
            '$route': function () {
                this.getArticles();
            }
        }

    }
</script>

<style scoped>

</style>
