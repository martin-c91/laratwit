export default {
    state: {
        authUser: {},
        user: {
            'id': 33,
            'slug': 'katyperry',
            'isFollowing': true,
        },
        tweets: [],
    },
    getters: {
        user(state) {
            return state.user;
        }
    },
    mutations: {
        changeUserIsFollowing(state) {
            // console.log('user.isFollowing should change' + payload);
            state.user.isFollowing = !state.user.isFollowing;
        }
    },

    actions: {
        postFollow({commit, state}, user) {
            commit('changeUserIsFollowing');
            // console.log('called ' + payload.slug + ' action payload '+ state.user.isFollowing);
            let url = '/api/following/';
            axios.post(url, {user})
                .then((response) => {
                        console.log(response);
                        commit('changeUserIsFollowing');
                    },
                )
        }
    }
}