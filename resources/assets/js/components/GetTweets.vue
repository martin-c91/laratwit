<template>
    <div>
        <div class="panel" v-for="(tweet, index) in tweets">
            <div class="panel-body mt-3 mb-3">
                <div style="float: left; width: 48px;">
                    <a :href="tweet.user.slug">
                        <img :src="tweet.user.avatar_url" class="avatar" alt="avatar">
                    </a>
                </div>
                <div style="margin-left: -48px; margin-left: 58px;">
                    <h6><a href=""></a></h6>
                    {{index}} | {{ tweet.content }}
                </div>
            </div>
            <div class="panel-footer">
                <div class="row float-right">
                    <div>
                        <a v-if="deleteConfirmation==tweet.id">Are you sure:
                            <a href="#" @click="deleteConfirmation=null;
                            postDeleteTweet({index: index, id: tweet.id})">Yes</a>
                            /
                            <a href="#" @click="deleteConfirmation=null">No</a>
                        </a>
                        <a v-if="!deleteConfirmation  && tweet.user.id==currentUser.id" @click="deleteTweet(tweet.id)">delete</a>
                    </div>
                    <div class="ml-2">
                        created: {{ tweet.created_at | moment("from", "now")}}
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import {sync} from 'vuex-pathify';

    export default {
        data(){
            return{
                deleteConfirmation: null,
            }
        },
        methods:{
            ...mapActions(['postDeleteTweet']),
            deleteTweet(id){
                this.deleteConfirmation = id;
            }
        },
        computed: {
            ...sync(['tweets', 'currentUser'])
        }
    }
</script>
