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
                            <img :src="'http://'+user.avatar_url" class="avatar" alt="avatar">
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
                                    @click="followUser(user, index)">Follow
                            </button>
                        </div>
                    </div>


                </div>
            </li>

        </ul>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

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
            ...mapActions(['postFollow']),

            followUser: function (user, index) {
                // console.log(user);
                this.postFollow({user, isFeaturedUser: true});
                this.featuredUsers.splice(index, 1);
                this.getFeaturedUsers(this.user.slug, 1);
            },

            getFeaturedUsers: function (slug, limit = 10, refresh = false) {
                let url = 'api/' + slug + '/getFeaturedUsers/' + limit;
                axios.post(url, {
                    'exceptUsers': this.exceptUsers
                })
                    .then((response) => {
                            if (!refresh) {
                                // console.log('refresh false');
                                this.exceptUsers = this.exceptUsers.concat(response.data.map(a => a.id));
                                this.featuredUsers = this.featuredUsers.concat(response.data);
                            }else{
                                // console.log('refresh true');
                                this.exceptUsers = response.data.map(a => a.id);
                                this.exceptUsers.push(this.user.id);
                                this.featuredUsers = response.data;
                            }
                        }
                    )
            },

            refresh: function () {
                this.getFeaturedUsers(this.user.slug, 10, true);
            }
        },
    }
</script>
