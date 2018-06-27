export default {
    state: {
        currentRoute: '',
        currentUser: {},
        user: {},
        tweets: [],
    },
    getters: {
        user: (state) => state.user,
        currentUser: (state) => state.currentUser,
        tweets: (state) => state.tweets,
        currentRoute: (state) => state.currentRoute,
    },
    mutations: {
        setData(state, data) {
            state.currentRoute = data.currentRoute;
            state.currentUser = data.currentUser;
            state.user = data.user;
        },
        changeUserIsFollowing(state) {
            state.user.isFollowing = !state.user.isFollowing;
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
    }
}