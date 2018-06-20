<template>
    <div class="card border-0 new-tweet-form">
        <form class="form-control" @submit.prevent="postTweet">
            <div class="form-group">
                <label>Tweet</label>
                <textarea class="form-control" v-model="content" :placeholder="placeholder" rows="3"></textarea>
            </div>
            <div class="form-group float-right">
                <button class="btn btn-default"
                        name="Submit">Submit
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                content: "",
                completed: false,
                placeholder: "What's on your mind?",

            };
        },

        methods: {
            postTweet() {
                axios.post('/api/timeline/store', {
                    content: this.content
                })
                    .catch(error => {
                        console.log(error.response);
                    })
                    .then(({data}) => {
                        this.content = '';
                        this.completed = true;
                    });
            }
        },
    }
</script>