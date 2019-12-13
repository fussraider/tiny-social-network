<template>
    <b-card
        class="mb-3 w-100"
        no-body
        tag="article"
    >

        <b-card-header>
            <b-link :to="url" class="h3 text-dark">
                {{ title }}
            </b-link>
        </b-card-header>

        <b-card-body class="pt-1">
            <div
                v-if="typeof owner != 'undefined'"
                class="owner"
            >
                <b-link :to="'/user/' + owner.id">{{ owner.name }}</b-link>
            </div>

            <span v-html="announceText"></span>
        </b-card-body>

        <b-card-footer>
            <b-row>
                <b-col cols="8">
                    <small class="text-muted">{{ created_at }}</small>
                </b-col>
                <b-col cols="4" class="text-right">
                    <like-button
                        :count="likes"
                        entity="article"
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
        name: "ArticleEntity",
        components: {LikeButton},
        props: [
            'title',
            'body',
            'url',
            'data_id',
            'likes',
            'owner',
            'created_at'
        ],
        data: () => {
            return {
                crop_size: 170,
            }
        },
        methods: {

            stripTags: function (str, allowed_tags) {
                let key = '';
                let allowed = false;
                let matches = [];
                let allowed_array = [];
                let allowed_tag = '';
                let i = 0;
                let k = '';
                let html = '';

                let replacer = function (search, replace, str) {
                    return str.split(search).join(replace);
                };

                if (allowed_tags) {
                    allowed_array = allowed_tags.match(/([a-zA-Z]+)/gi);
                }

                str += '';
                matches = str.match(/(<\/?[\S][^>]*>)/gi);

                for (key in matches) {
                    if (isNaN(key)) {
                        continue;
                    }

                    html = matches[key].toString();
                    allowed = false;

                    for (k in allowed_array) {
                        allowed_tag = allowed_array[k];
                        i = -1;

                        if (i != 0) {
                            i = html.toLowerCase().indexOf('<' + allowed_tag + '>');
                        }
                        if (i != 0) {
                            i = html.toLowerCase().indexOf('<' + allowed_tag + ' ');
                        }
                        if (i != 0) {
                            i = html.toLowerCase().indexOf('</' + allowed_tag);
                        }

                        if (i == 0) {
                            allowed = true;
                            break;
                        }
                    }

                    if (!allowed) {
                        str = replacer(html, "", str);
                    }
                }

                return str;
            },
        },

        computed: {
            announceText: function () {
                let text = this.stripTags(this.body);
                if (text.length > this.crop_size)
                    return text.slice(0, this.crop_size).replace(/\./gu, "\. ") + ' ...';
                else
                    return text;
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
</style>
