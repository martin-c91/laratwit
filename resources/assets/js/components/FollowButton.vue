<template>
    <div>
        <button v-if="this.AuthIsFollowing" class="btn btn-secondary" v-on:click="postFollow('unfollow')">UnFollow
        </button>
        <button v-else class="btn btn-primary" v-on:click="postFollow('follow')">Follow</button>

    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                AuthIsFollowing: this.user.AuthIsFollowing,
            }
        },

        methods: {
            postFollow: function (action) {
                var url = '/' + this.user.slug + '/' + action;
                axios.post(url)
                    .then((response) => {
                            console.log(this.user.AuthIsFollowing);
                        },
                    ),
                    (error) => {
                        console.log(error)
                    }

                this.AuthIsFollowing = !this.AuthIsFollowing;

            },
        },

        mounted() {
        }
    }
</script>