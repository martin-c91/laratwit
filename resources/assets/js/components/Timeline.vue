<template>
    <div>
        <div v-if="this.current_route_name === 'timeline'" class="card border-0 new-tweet-form">
            <form class="form-control" method="POST" action="" @submit.prevent="storeTweet">
                <div class="form-group">
                    <label>Tweet</label>
                    <textarea class="form-control" v-model="new_content" placeholder="What's on your mind..." rows="3"></textarea>
                </div>
                <div class="form-group float-right">
                    <button class="btn btn-default"
                            name="Submit"
                            >Submit
                    </button>
                </div>
            </form>
        </div>

        <br>
        <div class="panel">
            <div class="panel-header">Timeline</div>
            <GetTweets :tweets="tweets"></GetTweets>
        </div>

        <button class="btn btn-default" v-on:click="getMoreTweets">More...</button>
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
            if (this.current_route_name === 'timeline') {
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
                if (this.current_route_name !== 'timeline') {
                    return false;
                }
                    axios.post('api/timeline/store', {
                    content: this.new_content
                })
                    .then((response) => {
                            console.log(response.data);
                            this.tweets.unshift(response.data);
                            this.new_content = '';
                        }
                    )
            }
        },

        mounted() {
            this.fetchFirstTweets();
            axios.post('api/test/katyperry', {
                'exceptUsers': [
                    1,
                    2,
                    4,
                    55,
                ]
            })
                .then((response) => {
                        console.log(response.data)
                    }
                )
        }
    }
</script>