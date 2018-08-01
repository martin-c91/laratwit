<template>
    <div>
        <div v-for="tweet in tweets">
            <div class="panel-body mt-3 mb-3">
                <div style="float: left; width: 48px;">
                    <a :href="tweet.user.slug">
                        <img :src="tweet.user.avatar_url" class="avatar" alt="avatar">
                    </a>
                </div>
                <div style="margin-left: -48px; margin-left: 58px; ">
                    <h6><a href=""></a></h6>
                    {{ tweet.content }}
                </div>

                <div class="float-right">
                    created: {{ tweet.created_at | moment("from", "now")}}
                </div>

                <br>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['tweets'],

        data() {
            return {}
        }
    }
</script>
