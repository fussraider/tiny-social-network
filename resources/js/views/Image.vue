<template>
    <b-container>
        <b-row>
            <b-card
                class="mb-3 w-100"
                no-body
                tag="article"
            >
                <b-button-group
                    class="owner-buttons"
                    v-if="owner"
                    size="sm"
                >
                    <b-button
                        :to="'/image/' + image.id + '/edit'"
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
                <b-card-img
                    :src="'/storage/images/' + image.image"
                    class="card-img-top"
                ></b-card-img>

                <b-card-body class="text-justify">

                    <div
                        v-if="typeof image.owner != 'undefined'"
                        class="owner"
                    >
                        <b-link :to="'/user/' + image.owner.id">{{ image.owner.name }}</b-link>
                    </div>

                    {{ image.description }}
                </b-card-body>

                <b-card-footer>
                    <b-row>
                        <b-col cols="8">
                            <small class="text-muted">{{ image.created_at }}</small>
                        </b-col>
                        <b-col cols="4" class="text-right">
                            <like-button
                                v-if="typeof image.likes != 'undefined'"
                                :count="image.likes.length"
                                entity="image"
                                :entity_id="image.id"
                            ></like-button>
                        </b-col>
                    </b-row>

                </b-card-footer>
            </b-card>
        </b-row>
    </b-container>
</template>

<script>
    import ImageEntity from "../components/ImageEntity";
    import LikeButton from "@/js/components/LikeButton";
    export default {
        name: "Images",
        components: {ImageEntity, LikeButton},
        data: () => {
            return {
                image: {}
            }
        },

        mounted: function () {
            this.getImage();
        },

        methods: {
            getImage: function () {
                this.$http.get('image/' + this.$route.params.id)
                    .then(response => {
                        console.log(response);
                        if (response.data.result) {
                            this.image = response.data.data;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },


            removeConfirm: function () {
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete this image', {
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
                            this.$http.delete('image', {
                                data: {id: this.image.id}
                            })
                                .then(response => {
                                    if (response.data.result) {
                                        this.$router.push('/images');
                                    }
                                })
                                .catch(error => {
                                    this.$bvModal.msgBoxConfirm('The image could not be deleted. Refresh the page and try again.', {
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
                return this.image.user_id == this.$store.getters.userId
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
        top: -16px;
        right: 0;
        font-size: 10px;
        padding: 0 10px;
        background-color: rgba(255, 255, 255, .9);

        & > a {

            &:hover, &:visited, &:active {
                text-decoration: none;
            }
        }

    }

    .owner-buttons {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>
