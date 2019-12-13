<template>
    <b-container class="mb-5">
        <b-row>

            <b-alert
                class="w-100"
                v-if="images == null"
                variant="info"
                show
            >
                <i class="fas fa-spinner fa-spin"></i> Loading images...
            </b-alert>

            <template v-else-if="typeof images.data != 'undefined' && images.total > 0">
                <b-card-group columns>
                    <template v-for="image in (images.data || [])">
                        <image-entity
                            :img_src="'/storage/images/' + image.image"
                            :description="image.description"
                            :url="'/image/' + image.id"
                            :data_id="image.id"
                            :owner="image.owner"
                            :created_at="image.created_at"
                            :likes="image.likes.length"
                            thumb="true"
                        ></image-entity>
                    </template>
                </b-card-group>

                <b-pagination
                    v-if="typeof images != 'undefined' || images.last_page > 1"
                    v-model="images.current_page"
                    :total-rows="images.total"
                    :per-page="images.per_page"
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
                <span class="h2">No one has posted photos yet</span>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import ImageEntity from "../components/ImageEntity";

    export default {
        name: "Images",
        components: {ImageEntity},
        data: () => {
            return {
                images: null,
                page: 1
            }
        },

        mounted: function () {
            this.getImages();
        },

        methods: {
            getImages: function (page) {
                page = page || 1;
                this.images = null;

                this.$http.get('image_list', {
                    params: {
                        page: this.$route.params.page || 1
                    }
                })
                    .then(response => {
                        if (response.data.result) {
                            this.images = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },

            goPage(page) {
                this.$router.push('/images/' + page);
            },
        },

        watch: {
            '$route': function () {
                this.getImages();
            }
        }

    }
</script>

<style scoped>

</style>
