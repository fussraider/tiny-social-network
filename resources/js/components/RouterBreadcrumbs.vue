<template>
    <b-breadcrumb
        v-if="typeof items != 'undefined' && items.length"
        :items="items"
    ></b-breadcrumb>
</template>

<script>
    export default {
        name: "RouterBreadcrumbs",
        data: () => {
            return {
                items: []
            }
        },
        mounted: function () {
            this.updateList();
        },
        methods: {
            updateList: function () {
                this.items = this.$route.meta.breadcrumb;
            }
        },
        watch: {
            '$route': function () {
                this.updateList();
            }
        }
    }
</script>
