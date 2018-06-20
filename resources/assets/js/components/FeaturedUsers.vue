<template>
    <div class="card" style="width: 18rem;">
        <div class="card-header">
            Featured Users
            <a class="float-right text-secondary" href="#" @click="refresh">
                Refresh
            </a>
        </div>

        <ul class="list-group list-group-flush border-0">
            <li v-for="(user, index) in featuredUsers" :key="user.id" class="list-group-item border-0">
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
                            <button class="btn btn-sm btn-outline-primary"
                                    @click="postFollow('follow', user.slug, index)">Follow
                            </button>
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
                featuredUsers: [],
                exceptUsers: [this.user.id],
            }
        },

        created() {
            this.getFeaturedUsers(this.user.slug);
        },

        methods: {
            postFollow: function (action, user_slug, index) {
                let url = '/api/' + user_slug + '/' + action;
                axios.post(url)
                    .then((response) => {
                            this.featuredUsers.splice(index, 1);
                            this.getFeaturedUsers(this.user.slug, 1);
                        },
                    ),
                    (error) => {
                        console.log(error)
                    }
            },

            getFeaturedUsers: function (slug, limit = 10) {
                let featuredUsers = [];
                let url = 'api/' + slug + '/getFeaturedUsers/' + limit;
                axios.post(url, {
                    'exceptUsers': this.exceptUsers
                })
                    .then((response) => {
                            this.exceptUsers = this.exceptUsers.concat(response.data.map(a => a.id));
                            this.featuredUsers = this.featuredUsers.concat(response.data);
                        }
                    )
            },

            refresh: function () {
                console.log('refreshed.');
            }
        },

        mounted() {
        }
    }
</script>