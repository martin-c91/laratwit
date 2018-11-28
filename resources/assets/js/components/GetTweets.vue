<template>
    <div>
        <div class="panel border-top rounded-top" v-for="(tweet, index) in tweets">
            <div class="panel-body mt-3 mb-3 h-50">
                <div style="float: left; width: 48px;">
                    <a :href="tweet.user.slug">
                        <img :src="tweet.user.avatar_url" class="avatar" alt="avatar">
                    </a>
                </div>
                <div style="margin-left: -48px; margin-left: 58px;">
                    <h5><a href="">{{tweet.user.slug}}</a></h5>
                    <a>{{ tweet.content }}</a>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">

                    <div class="col text-right float-right " style="padding-right: 0">
                        <a v-if="deleteConfirmation==tweet.id">Are you sure:
                            <a href="#" @click="deleteConfirmation=null;
                            postDeleteTweet({index: index, id: tweet.id})">Yes</a>
                            /
                            <a href="#" @click="deleteConfirmation=null">No</a>
                        </a>
                        <a v-if="!deleteConfirmation  && tweet.user.id==currentUser.id" @click="deleteTweet(tweet.id)">delete</a>
                    </div>

                    <div class="col-1 float-right text-right" style="padding-right: 0px; padding-left:0px">
                        <a href="#" @click="postLikeTweet(tweet)">
                            {{tweet.likes}}
                            <i style="color: red;" class="far fa-heart"></i>
                        </a>
                    </div>

                    <div class="col-4 float-right" style="padding-left: 10px">

                        posted: {{ tweet.created_at | moment("from", "now")}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import {sync} from 'vuex-pathify';

    export default {
        data() {
            return {
                deleteConfirmation: null,
            }
        },
        methods: {
            ...mapActions(['postDeleteTweet', 'postLikeTweet']),
            deleteTweet(id) {
                this.deleteConfirmation = id;
            }
        },
        computed: {
            ...sync(['tweets', 'currentUser'])
        }
    }
</script>
