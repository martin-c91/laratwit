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
                tweets: [
                    {
                        id: '0',
                        content: 'one',
                    },
                    {
                        id: '1',
                        content: 'two',
                    },
                    {
                        id: '2',
                        content: 'three',
                    },
                ],
                tweet_id: '',
                pagination: {},
            }
        },

        created() {
            this.fetchTweets();
        },

        methods: {
            fetchTweets() {
                fetch('')
                    .then(res => res.json())
                    .then(res => {
                    })
            }
        }
    }
</script>