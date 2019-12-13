<template>
    <b-card
        class="mb-3 w-100"
        no-body
        tag="article"
    >

        <b-link :to="url">
            <b-card-img
                :src="img_src"
                class="card-img-top"
            ></b-card-img>
        </b-link>

        <b-card-body class="text-justify">

            <div
                v-if="typeof owner != 'undefined'"
                class="owner"
            >
                <b-link :to="'/user/' + owner.id">{{ owner.name }}</b-link>
            </div>

            {{ description }}
        </b-card-body>

        <b-card-footer>
            <b-row>
                <b-col cols="8">
                    <small class="text-muted">{{ created_at }}</small>
                </b-col>
                <b-col cols="4" class="text-right">
                    <like-button
                        :count="likes"
                        entity="image"
                        :entity_id="data_id"
                    ></like-button>
                </b-col>
            </b-row>

        </b-card-footer>
    </b-card>
</template>

<script>
    import LikeButton from "@/js/components/LikeButton";
    export default {
        name: "ImageEntity",
        components: {LikeButton},
        props: [
            'img_src',
            'description',
            'url',
            'data_id',
            'likes',
            'created_at',
            'owner',
            'thumb'
        ]
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
