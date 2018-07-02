export default {
    state: {
        currentRoute: '',
        currentUser: {},
        user: {},
        newContent: '',
        tweets: [],
        tweetsPagination: {
            current_page: null,
            next_page_url: null,
            path: null,
        },
        loading: {}
    },
    getters: {
        user: (state) => state.user,
        currentUser: (state) => state.currentUser,
        tweets: (state) => state.tweets,
        currentRoute: (state) => state.currentRoute,
        newContent: (state) => state.newContent,
        // tweets: (state) => state.tweets,
        loading: (state) => state.loading,
    },
    mutations: {
        setData(state, data) {
            state.currentRoute = data.currentRoute;
            state.currentUser = data.currentUser;
            state.user = data.user;
        },
        changeUserIsFollowing(state) {
            state.user.isFollowing = !state.user.isFollowing;
        },
        changeLoading(state, payload) {
            state.loading = Object.assign({}, payload);
        }
        // updateTimeline: state (timeline) =>
    },
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
                        state.tweetsPagination.next_page_url = response.data.next_page_url;
                        state.tweets = state.tweets.concat(response.data.data);
                        commit('changeLoading', {'fetchTweets': false});
                    }
                )
        },
    }
}