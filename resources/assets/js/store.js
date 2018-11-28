import {make} from 'vuex-pathify';
// import {} from 'vuex-pathify';
var JSONbig = require('json-bigint');

const state = {
    currentRoute: '',
    currentUser: {},
    user: {},
    newContent: '',
    tweets: [],
    tweetsPagination: {},
    loading: {}
};

const mutations = {
    ...make.mutations(state),
    TOGGLE_USER_IS_FOLLOWING(state) {
        state.user.isFollowing = !state.user.isFollowing;
    },
    POST_AND_RESET_NEW_CONTENT(state, tweet) {
        state.tweets.unshift(tweet);
        state.newContent = '';
    },
    APPEND_TWEETS(state, additional_tweets) {
        state.tweets = state.tweets.concat(additional_tweets);
    },
    REMOVE_TWEET(state, index){
        state.tweets.splice(index, 1);
    }
};
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

export default {
    strict: true,
    state,
    mutations,
    actions: {
        postFollow({commit, state}, {user, isFeaturedUser = false}) {
            let url = 'api/following/' + user.id;
            axios.post(url).then(() => {
                if (!isFeaturedUser) {
                    commit('TOGGLE_USER_IS_FOLLOWING');
                }
            })
        },
        postUnFollow({commit, state}, {user}) {
            let url = 'api/following/' + user.id;
            axios.delete(url).then((response) => {
                commit('TOGGLE_USER_IS_FOLLOWING')
            })
        },

        fetchTweets({commit, state}) {
            let url = '';
            commit('SET_LOADING', {'fetchTweets': true});
            if (!state.tweetsPagination.next_page_url) {
                if (state.currentRoute === 'timeline') {
                    url = 'api/timeline';
                } else {
                    url = 'api/' + state.user.slug;
                }
            } else {
                url = state.tweetsPagination.next_page_url;
            }
            axios.get(url, {transformResponse: data => JSONbig.parse(data)})
                .then((response) => {
                        commit('APPEND_TWEETS', response.data.data);
                        delete response.data.data;
                        commit('SET_TWEETS_PAGINATION', response.data);
                        commit('SET_LOADING', {'fetchTweets': false});
                    }
                )
        },

        postNewTweet({commit, state}, newContent) {
            axios.post('api/timeline/store', {
                content: newContent
            },
                {transformResponse: data => JSONbig.parse(data)}
            )
                .then((response) => {
                        // console.log(response.data);
                        commit('POST_AND_RESET_NEW_CONTENT', response.data);
                        //     this.commit('SET_NEW_CONTENT', response.data.data.content);
                    }
                )
        },

        postDeleteTweet({commit, state}, {index, id}) {
            console.log('api/tweet/'+id);
            axios.delete('api/tweet/' + id)
                .then((response) => {
                        console.log(index);
                        commit('REMOVE_TWEET', index);
                    }
                )
        },

        postLikeTweet({commit, state}, tweet){
            console.log(tweet)
        }
    }
}
