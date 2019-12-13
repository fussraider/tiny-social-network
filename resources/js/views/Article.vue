<template>
    <b-container class="mb-5">
        <b-row>
            <b-card
                class="mb-3 w-100"
                no-body
                tag="article"
            >
                <b-card-header>
                    <b-row>
                        <b-col cols-8>
                            <span class="h3 text-dark">
                                {{ article.title }}
                            </span>
                        </b-col>
                        <b-col cols="4" class="text-right">
                            <b-button-group
                                class="owner-buttons"
                                v-if="owner"
                                size="sm"
                            >
                                <b-button
                                    :to="'/article/' + article.id + '/edit'"
                                    variant="primary"
                                >
                                    <i class="fas fa-edit"></i>
                                </b-button>

                                <b-button
                                    @click="removeConfirm"
                                    variant="danger"
                                >
                                    <i class="fas fa-times"></i>
                                </b-button>
                            </b-button-group>
                        </b-col>
                    </b-row>
                </b-card-header>

                <b-card-body class="pt-1">


                    <div
                        v-if="typeof article.owner != 'undefined'"
                        class="owner"
                    >
                        <b-link :to="'/user/' + article.owner.id">{{ article.owner.name }}</b-link>
                    </div>

                    <span v-html="article.body"></span>
                </b-card-body>

                <b-card-footer>
                    <b-row>
                        <b-col cols="8">
                            <small class="text-muted">{{ article.created_at }}</small>
                        </b-col>
                        <b-col cols="4" class="text-right">
                            <like-button
                                v-if="typeof article.likes != 'undefined'"
                                :count="article.likes.length"
                                entity="article"
                                :entity_id="Number(article.id)"
                            ></like-button>
                        </b-col>
                    </b-row>
                </b-card-footer>
            </b-card>
        </b-row>

    </b-container>
</template>

<script>
    import ArticleEntity from "../components/ArticleEntity";
    import LikeButton from "@/js/components/LikeButton";

    export default {
        name: "Article",
        components: {ArticleEntity, LikeButton},
        data: () => {
            return {
                article: {}
            }
        },

        mounted: function () {
            this.getArticle();
        },

        methods: {
            getArticle: function () {
                this.$http.get('article/' + this.$route.params.id)
                    .then(response => {
                        if (response.data.result) {
                            this.article = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },

            removeConfirm: function () {
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete this article', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if (value) {
                            this.$http.delete('article', {
                                data: {id: this.article.id}
                            })
                                .then(response => {
                                    if (response.data.result) {
                                        this.$router.push('/articles');
                                    }
                                })
                                .catch(error => {
                                    this.$bvModal.msgBoxConfirm('The article could not be deleted. Refresh the page and try again.', {
                                        title: 'Warning',
                                        size: 'sm',
                                        buttonSize: 'sm',
                                        okVariant: 'warning',
                                        okTitle: 'OK',
                                        footerClass: 'p-2',
                                        hideHeaderClose: true,
                                        centered: true
                                    });
                                })
                        }
                    })
                    .catch(err => {
                        // An error occurred
                    })
            }
        },

        computed: {
            owner: function () {
                return this.article.user_id == this.$store.getters.userId
            }
        }

    }
</script>

<style scoped lang="scss">
    .card-body {
        position: relative
    }

    .owner {
        position: absolute;
        top: -17px;
        right: 0;
        padding: 0 10px;
        font-size: 10px;
        background-color: rgba(255, 255, 255, .9);

        & > a {

            &:hover, &:visited, &:active {
                text-decoration: none;
            }
        }

    }

    .owner-buttons {
        position: absolute;
        top: -7px;
        right: 0px;
    }
</style>
