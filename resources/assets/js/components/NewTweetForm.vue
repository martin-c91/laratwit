<template>
    <div class="card border-0 new-tweet-form">
        <form class="form-control" method="POST" action="" @submit.prevent="postNewTweet(newContent)">
            <div class="form-group">
                <label>Tweet</label>
                <textarea class="form-control"
                          :value="newContent"
                          placeholder="What's on your mind..."
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
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        // data(){
        //     return {
        //         'newContent': 'sfssdf'
        //     }
        // },
        // methods: {
        //     postNewTweet(payload){
        //         console.log(payload)
        //     }
        // },
        methods: {...mapActions(['postNewTweet'])},
        computed: {
            newContent: {
                get() {
                    return this.$store.state.newContent
                },
                set(value) {
                    this.$store.commit('updateNewContent', value)
                }
            }
        },
    }
</script>
