<template>
    <b-container>
        <b-row>
            <image-form
                :image_id="$route.params.id"
            ></image-form>
        </b-row>
    </b-container>
</template>

<script>
    import ImageForm from "../components/ImageForm";

    export default {
        name: "Publish",
        components: {ImageForm},
        data: () => {
            return {
                image: {},
            }
        },

        mounted: function () {
        },

        methods: {}
    }
</script>

<style scoped>

</style>
