<template>

    <b-container>

        <b-row v-if="entity == 'article'">
            <article-form></article-form>
        </b-row>

        <b-row v-else-if="entity == 'image'">
            <image-form></image-form>
        </b-row>

        <b-row v-else>
            <b-col cols="6">
                <b-button
                    variant="outline-success"
                    class="w-100 py-5"
                    @click="setEntity('article')"
                >
                    <i class="far fa-newspaper fa-9x"></i><br/>
                    <h1>NEWS</h1>
                </b-button>
            </b-col>

            <b-col cols="6">
                <b-button
                    variant="outline-success"
                    class="w-100 py-5"
                    @click="setEntity('image')"
                >
                    <i class="far fa-image fa-9x"></i><br/>
                    <h1>PHOTO</h1>
                </b-button>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import ArticleForm from "@/js/components/ArticleForm";
    import ImageForm from "@/js/components/ImageForm";

    export default {
        name: "Publish",
        components: {ImageForm, ArticleForm},
        data: () => {
            return {
                entity: false,
            }
        },

        methods: {
            setEntity: function (entity) {
                this.entity = entity;
            }
        }
    }
</script>

<style scoped>

</style>
