<template>
    <div>
        <!--<tweet v-for="tweet in tweets"-->
               <!--:tweet="tweet"-->
               <!--:key="tweet.id"-->
        <!--&gt;</tweet>-->

        <button class="btn btn-default" v-on:click="getMoreTweets">More...</button>
    </div>
</template>

<script>
    export default {
        props: ['user','current_route_name'],

        data() {
            return {
                tweets: [],
                url:'',
            }
        },

        created() {
            if(this.current_route_name=='timeline'){
                this.url = '/api/timeline';
            }else{
                this.url = '/api/'+this.user.slug;
            }
            console.log(this.url)
        },

        methods: {
            fetchTweets() {
                axios.get(this.url)
                    .then((response) => {
                            console.log(response.data);
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
    }
</script>