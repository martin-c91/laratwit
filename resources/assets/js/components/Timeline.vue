<template>
    <div>
        <div class="card border-0 new-tweet-form">
            <form class="form-control" method="POST" action="" @submit.prevent="storeTweet">
                <div class="form-group">
                    <label>Tweet</label>
                    <textarea class="form-control" v-model="new_content" placeholder="placeholder" rows="3"></textarea>
                </div>
                <div class="form-group float-right">
                    <button class="btn btn-default"
                            name="Submit"
                            @click="storeTweet">Submit
                    </button>
                </div>
            </form>
        </div>

        <br>

        <!--<tweet v-for="tweet in tweets"-->
        <!--:tweet="tweet"-->
        <!--:key="tweet.id"-->
        <!--&gt;</tweet>-->
        <br>
        <div class="panel">
            <div class="panel-header">Timeline</div>
            <GetTweets :tweets="tweets"></GetTweets>
        </div>

        <button class="btn btn-default" v-on:click="getMoreTweets">More...</button>
        <button class="btn btn-default" v-on:click="storeTweet">Tese</button>
    </div>
</template>

<script>
    import GetTweets from "./GetTweets";
    export default {
        components: {GetTweets},
        props: ['user', 'current_route_name'],

        data() {
            return {
                tweets: [],
                url: '',
                nextPageUrl: '',
                new_content: ''
            }
        },

        created() {
            if (this.current_route_name == 'timeline') {
                this.url = '/api/timeline';
            } else {
                this.url = '/api/' + this.user.slug;
            }
        },

        methods: {
            fetchFirstTweets() {
                axios.get(this.url)
                    .then((response) => {
                            this.nextPageUrl = response.data.next_page_url;
                            this.tweets = response.data.data;
                        }
                    )
            },

            getMoreTweets: function () {
                axios.get(this.nextPageUrl)
                    .then((response) => {
                            this.nextPageUrl = response.data.next_page_url;
                            this.tweets = this.tweets.concat(response.data.data);
                        }
                    )
            },

            storeTweet: function () {
                axios.post('api/timeline/store', {
                    content: this.new_content
                })
                    .then((response) => {
                            console.log(response.data);
                            this.tweets.unshift(response.data);
                        }
                    )
            }
        },

        mounted() {
            this.fetchFirstTweets();
        }
    }
</script>