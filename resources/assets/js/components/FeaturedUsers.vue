<template>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Featured Users
        </div>

        <ul class="list-group list-group-flush border-0">
            <li v-for="user in featuredUsers" class="list-group-item border-0">
                <div class="row">
                    <div style="float: left; margin-left: 8px ;width: 48px;">
                        <a :href="user.slug">
                            <img :src="user.avatar_url" class="avatar" alt="avatar">
                        </a>
                    </div>

                    <div style="margin-left: 28px">
                        <div class="row">
                            <a :href="user.slug" v-text="'@'+user.slug"></a>
                        </div>
                        <div class="row">
                            <button class="btn btn-sm btn-outline-primary">Follow</button>
                        </div>
                    </div>


                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                featuredUsers: []
            }
        },

        methods: {
            postFollow: function (action) {
                var url = '/api/' + this.user.slug + '/' + action;
                // console.log(url);
                axios.post(url)
                    .then((response) => {
                            // console.log(this.user.AuthIsFollowing);
                        },
                    ),
                    (error) => {
                        console.log(error)
                    }

                this.AuthIsFollowing = !this.AuthIsFollowing;

            },

            getFeaturedUsers: function () {
                axios.post('api/test/katyperry/5', {
                    'exceptUsers': [
                        1,
                        2,
                        4,
                        55,
                    ]
                })
                    .then((response) => {
                            this.featuredUsers = response.data;
                        }
                    )
            }
        },

        mounted() {
            this.getFeaturedUsers();
        }
    }
</script>