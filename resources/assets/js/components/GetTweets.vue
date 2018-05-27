<template>
    <div>
        <h2>

        </h2>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tweets: []
            }
        },

        created() {
            this.fetchTweets();
        },

        methods: {
            fetchTweets() {
                fetch(location.pathname)
                    .then(res => res.json())
                    .then(console.log(res))
            }
        },

        mounted(){
            this.fetchTweets();
        }
    }
</script>