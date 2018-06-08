<template>
    <div>

        <div v-for="tweet in tweets">
            <div class="panel-body mt-3 mb-3">
                <div style="float: left; width: 48px;">
                    <img :src="tweet.user.avatar_url" class="avatar"
                         alt="avatar">
                </div>
                <div style="margin-left: -48px; margin-left: 58px; ">
                    <h6><a href=""></a></h6>
                    {{ tweet.content }}
                </div>

                <div class="float-right">
                    created: {{ tweet.created_at | moment("from", "now")}}
                </div>

                <br>
            </div>
        </div>

        <button v-on:click="getMoreTweets">Add 1</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tweets: [],
                nextPageUrl: '',
            }
        },

        created() {
            this.fetchTweets();
        },

        methods: {
            fetchTweets() {
                axios.get('')
                    .then((response) => {
                        this.nextPageUrl = response.data.next_page_url;
                        this.tweets = response.data.data;
                        }
                    )
            },

            getMoreTweets: function(){
                axios.get(this.nextPageUrl)
                    .then(response => {
                        this.nextPageUrl = response.data.next_page_url;
                        this.tweets = this.tweets.concat(response.data.data);
                    });
            }
        },

        mounted() {
            // this.fetchTweets();
        }
    }
</script>