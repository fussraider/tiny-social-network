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
            label="Image"
            label-for="image"
        >
            <b-form-file
                v-if="!image_id"
                id="image"
                :disabled="in_process"
                :state="checkState('image')"
                placeholder="Choose a image or drop it here..."
                drop-placeholder="Drop image here..."
                @input="selectFile"
                required
            ></b-form-file>

            <b-img
                v-else
                :src="'/storage/images/' + image.image"
                fluid
            ></b-img>

        </b-form-group>

        <b-form-group
            label="Description"
            label-for="description"
        >
            <b-form-textarea
                id="description"
                v-model="image.description"
                :disabled="in_process"
                :class="checkState('description')"
                required
            ></b-form-textarea>
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
    export default {
        name: "ImageForm",
        props: {
            image_id: {
                default: null
            }
        },
        data: () => {
            return {
                image: {
                    description: '',
                    image: null,
                    id: '',
                },

                errors: null,
                errorMessage: null,
                in_process: false,
            }
        },

        mounted: function () {
            if (this.$props.image_id) {
                this.getImage();
            }
        },

        methods: {
            submitForm: function () {
                this.in_process = true;
                let api = null;

                let formData = new FormData();
                formData.append('entity', 'image');
                formData.append('description', this.image.description);

                if(this.image_id) {
                    api = 'update';
                    formData.append('id', this.image.id);
                } else {
                    api = 'publish';
                    formData.append('image', this.image.image);
                }

                this.$http.post(api,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(response)

                        if (response.data.result) {
                            this.$router.push('/image/' + response.data.data.id);
                        } else
                            this.in_process = false;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                        this.errorMessage = error.response.data.message;
                        this.in_process = false;
                    })
            },

            getImage: function () {
                this.$http.get('image/' + this.image_id)
                    .then(response => {
                        if (response.data.result) {
                            this.image = response.data.data;
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
            },

            selectFile: function(input){
                this.image.image = input;
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
