<template>
    <div>
        <NewTweetForm v-if="this.currentRoute === 'timeline'"></NewTweetForm>
        <br>
        <div class="panel-group">
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
    import NewTweetForm from "./NewTweetForm";
    import {mapActions} from 'vuex';
    import {sync} from 'vuex-pathify';

    export default {
        components: {GetTweets, NewTweetForm},
        methods: {
            ...mapActions(['fetchTweets']),
        },

        mounted() {
            this.fetchTweets();
        },

        computed: {
            ...sync(['currentRoute', 'currentUser', 'user', 'tweets', 'loading'])
        }
    }
</script>
