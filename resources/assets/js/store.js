export default {
    state: {
        currentUser: {},
        user: {},
        tweets: [],
    },
    getters: {
        user(state) {
            return state.user;
        },
        currentUser(state) {
            return state.currentUser;
        },
        tweets(state) {
            return state.tweets;
        },
    },
    mutations: {
        setData(state, data) {
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