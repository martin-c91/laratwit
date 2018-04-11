<template>
<div>
    <h2>

    </h2>
</div>
</template>

<script>
    export default {
        data(){
            return{
                tweets: [],
                tweet: {
                    id: '',
                    content: '',
                },
                tweet_id: '',
                pagination: {},
            }
        },

        created(){
            this.fetchTweets();
        },

        methods: {
            fetchTweets(){
                fetch('api/tweets')
                    .then(res => res.json())
                    .then(res => {
                        console.log(res.data);
                    })
            }
        }
    }
</script>