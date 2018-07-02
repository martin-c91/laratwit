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
        {{asdf}}
        <button v-if="!loading.fetchTweets" class="btn btn-default" v-on:click="fetchTweets">More...</button>
    </div>
</template>

<script>
    import GetTweets from "./GetTweets";
    import {mapGetters, mapActions} from 'vuex';

    export default {
        components: {GetTweets},
        methods: {
            ...mapActions(['fetchTweets']),
            storeTweet: function () {
                // axios.post('api/timeline/store', {
                //     content: this.newContent
                // })
                //     .then((response) => {
                //             // console.log(response.data);
                //             this.tweets.unshift(response.data);
                //             this.newContent = '';
                //         }
                //     )
            }
        },

        mounted() {
            this.fetchTweets();
        },

        computed: {
            ...mapGetters(['currentRoute', 'currentUser', 'user', 'newContent', 'tweets', 'loading'])
        }
    }
</script>