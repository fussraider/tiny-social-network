<template>
    <b-form
        class="w-100"
        @submit.prevent="submitForm"
    >

        <b-alert variant="danger" dismissible :show="errors != null">
            <h4><i class="fas fa-exclamation-circle"></i> {{ errorMessage }}</h4>
            <span v-html="errorsMessage"></span>
        </b-alert>

        <b-form-group
            label="Title"
            label-for="title"
        >
            <b-form-input
                type="text"
                id="title"
                v-model="article.title"
                :disabled="in_process"
                :state="checkState('title')"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group
            label="Body"
            label-for="body"
        >
            <vue-editor
                id="body"
                v-model="article.body"
                :disabled="in_process"
                :class="checkState('body') == false ? 'border border-danger' : ''"
                required
            ></vue-editor>
        </b-form-group>

        <b-button
            type="submit"
            class="btn-success"
            :disabled="in_process"
        >
            <i v-if="in_process" class="fas fa-spinner fa-spin "></i>
            <i v-else class="fas fa-share"></i>
            Publish
        </b-button>
    </b-form>
</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        name: "ArticleForm",
        components: {VueEditor},
        props: {
            article_id: {
                default: null
            }
        },
        data: () => {
            return {
                article: {
                    title: '',
                    body: '',
                    id: '',
                },
                errors: null,
                errorMessage: null,
                in_process: false,
            }
        },

        mounted: function () {
            if (this.$props.article_id) {
                this.getArticle();
            }
        },

        methods: {
            submitForm: function () {
                this.in_process = true;
                let api = this.article_id ? 'update' : 'publish';

                this.$http.put(api, {entity: 'article', ...this.article})
                    .then(response => {
                        console.log(response)

                        if (response.data.result) {
                            this.$router.push('/article/' + response.data.data.id);
                        } else
                            this.in_process = false;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                        this.errorMessage = error.response.data.message;
                        this.in_process = false;
                    })
            },

            getArticle: function () {
                this.$http.get('article/' + this.article_id)
                    .then(response => {
                        if (response.data.result) {
                            this.article = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },

            checkState: function (input) {
                let res = null;

                if (this.errors !== null && typeof this.errors[input] != "undefined") {
                    res = !this.errors[input].length > 0;
                }

                return res;
            }
        },

        computed: {
            errorsMessage: function () {
                let text = '';

                if (this.errors !== null) {
                    for (let i in this.errors) {
                        text += '<li>' + this.errors[i] + '</li>'
                    }
                }

                return text;
            }
        }
    }
</script>

<style scoped>

</style>
