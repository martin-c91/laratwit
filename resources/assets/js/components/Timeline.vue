<template>
    <div>
        <div v-if="this.currentRoute === 'timeline'" class="card border-0 new-tweet-form">
            <form class="form-control" method="POST" action="" @submit.prevent="storeTweet">
                <div class="form-group">
                    <label>Tweet</label>
                    <textarea class="form-control" v-model="newContent" placeholder="What's on your mind..."
                              rows="3"></textarea>
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
            <a>Timeline for {{user.slug}}</a>
            <div class="panel-header">Timeline</div>
            <GetTweets :tweets="tweets"></GetTweets>
        </div>

        <div v-if="loading.fetchTweets">
            Loading....
        </div>
        <button v-if="!loading.fetchTweets" class="btn btn-default" v-on:click="fetchTweets">More...</button>
    </div>
</template>

<script>
    import GetTweets from "./GetTweets";
    import {mapGetters} from 'vuex';

    export default {
        components: {GetTweets},
        data() {
            return {
                newContent: '',
                tweets: [],
                tweetsPagination: {
                    current_page: null,
                    next_page_url: null,
                    path: null,
                },
                loading: {
                    fetchTweets: false,
                }
            }
        },
        methods: {
            fetchTweets() {
                let url;
                this.loading.fetchTweets = true;
                if (!this.tweetsPagination.next_page_url) {
                    if (this.currentRoute === 'timeline') {
                        url = 'api/timeline';
                    }
                    else {
                        url = 'api/' + this.user.slug;
                    }
                } else {
                    url = this.tweetsPagination.next_page_url;
                }
                // console.log(url);
                axios.get(url)
                    .then((response) => {
                            this.tweetsPagination.next_page_url = response.data.next_page_url;
                            this.tweets = this.tweets.concat(response.data.data);
                            this.loading.fetchTweets = false;
                        }
                    )
            },

            storeTweet: function () {
                axios.post('api/timeline/store', {
                    content: this.newContent
                })
                    .then((response) => {
                            // console.log(response.data);
                            this.tweets.unshift(response.data);
                            this.newContent = '';
                        }
                    )
            }
        },

        mounted() {
            this.fetchTweets();
        },

        computed: {
            ...mapGetters(['currentRoute', 'currentUser', 'user'])
        }
    }
</script>