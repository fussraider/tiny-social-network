<template>
    <button
        @click="clickBtn"
        class="btn btn-sm text-text-muted"
    >
        <i class="far fa-heart"></i> {{ likes }}
    </button>
</template>

<script>
    export default {
        name: "LikeButton",
        props: {
            count: {
                default: 0,
                type: Number
            },
            entity: {
                required: true,
                type: String
            },
            entity_id: {
                required: true,
                type: Number
            }
        },
        data: () => {
            return {
                likes: 0
            }
        },

        mounted: function(){
            this.likes = this.count
        },

        methods: {
            clickBtn: function () {
                this.$http.put(this.entity + '/' + this.entity_id + '/like')
                    .then(response => {
                        if(response.data.result){
                            this.likes = response.data.data.likes
                        }
                    })
                    .catch(error => {

                    })
            },
        }
    }
</script>

<style scoped>

</style>
