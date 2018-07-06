import { make } from 'vuex-pathify';

export default {
    strict: true,
    state: {
        currentRoute: '',
        currentUser: {},
        user: {},
        newContent: '',
        tweets: [],
        tweetsPagination: {},
        loading: {}
    },
    getters: {
        user: (state) => state.user,
        currentUser: (state) => state.currentUser,
        tweets: (state) => state.tweets,
        currentRoute: (state) => state.currentRoute,
        newContent: (state) => state.newContent,
        loading: (state) => state.loading,
    },
    mutations: make.mutations(this.state),
    //     {
    //     setData(state, data) {
    //         // state.objec
    //         state.currentRoute = data.currentRoute;
    //         state.currentUser = data.currentUser;
    //         state.user = data.user;
    //     },
    //     setNewContent(state, payload) {
    //         state.newContent = payload;
    //     },
    //     changeUserIsFollowing(state) {
    //         state.user.isFollowing = !state.user.isFollowing;
    //     },
    //     changeLoading(state, payload) {
    //         state.loading = Object.assign({}, payload);
    //     },
    //     postNewContent(state, tweet) {
    //         state.newContent = '';
    //         this.state.tweets.unshift(tweet);
    //         this.state.newContent = '';
    //     }
    //     // updateTimeline: state (timeline) =>
    // },
    actions: {
        postFollow({commit, state}, user) {
            let url = 'api/following/' + user.id;
            axios.post(url).then((response) => {
                commit('changeUserIsFollowing')
            })
        },
        postUnFollow({commit, state}, user) {
            let url = 'api/following/' + user.id;
            axios.delete(url).then((response) => {
                commit('changeUserIsFollowing')
            })
        },

        fetchTweets({commit, state}) {
            let url;
            commit('changeLoading', {'fetchTweets': true});
            if (!state.tweetsPagination.next_page_url) {
                if (state.currentRoute === 'timeline') {
                    url = 'api/timeline';
                }
                else {
                    url = 'api/' + state.user.slug;
                }
            } else {
                url = state.tweetsPagination.next_page_url;
            }
            axios.get(url)
                .then((response) => {
                        // commit('setData', {'tweetsPagination':{ }});
                        // state.tweetsPagination.next_page_url = response.data.next_page_url;
                        // state.tweets = state.tweets.concat(response.data.data);
                        commit('changeLoading', {'fetchTweets': false});
                    }
                )
        },

        postNewTweet({commit, state}, newContent) {
            axios.post('api/timeline/store', {
                content: newContent
            })
                .then((response) => {
                        this.commit('postNewContent', response.data);
                        // this.commit('resetNewContent');
                        // console.log(response.data);
                    }
                )
        }
    }
}
