<template>
    <form class="form-control" method="POST" action="" @submit.prevent="addTweet">
        <div class="form-group">
            <label>Tweet</label>
            <textarea class="form-control" v-model="content" :placeholder="placeholder" rows="3"></textarea>
        </div>
        <div class="form-group float-right">
            <button class="btn btn-default"
                    name="Submit"
                    @click="addTweet">Submit</button>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                content: "",
                placeholder: "What's on your mind?",

            };
        },

        methods: {
            addTweet(){
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted.');
                    });
                console.log((location.pathname)+'/tweet');
            }
        },

        mounted() {

        },

    }
</script>