<template>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Featured Users
            <a class="float-right text-secondary" href="#" @click="refresh">
                Refresh
            </a>
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
                            <b v-text="user.name"> </b>
                            <!--<a style="margin-left: 5px;" class="text-secondary" :href="user.slug"-->
                               <!--v-text="' @'+user.slug"></a>-->
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
            },

            refresh: function(){
                console.log('refreshed.');
            }
        },

        mounted() {
            this.getFeaturedUsers();
        }
    }
</script>