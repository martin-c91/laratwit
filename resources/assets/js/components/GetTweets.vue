<template>
    <ul>
        <li v-for="tweet in tweets">
            {{tweet.content}}
            <div class="panel-body mt-3 mb-3">
                <div style="float: left; width: 48px;">
                    <img class="avatar"
                         src=""
                         alt="avatar">
                </div>
                <div style="margin-left: -48px; margin-left: 58px; ">
                    <h6><a href=""></a></h6>
                    {{ tweet.content }}
                </div>

                <div class="float-right">
                    created: {{ tweet.created_at | moment("from", "now")}}
                </div>

            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        data() {
            return {
                tweets: []
            }
        },

        created() {
            // this.fetchTweets();
        },

        methods: {
            fetchTweets() {
                axios.get('http://laratwit.test/test/jimmyfallon')
                    .then((response) => {
                        this.tweets = response.data.data;
                        console.log(this.tweets);
                        }
                    )
            }
        },

        mounted() {
            this.fetchTweets();
        }
    }
</script>