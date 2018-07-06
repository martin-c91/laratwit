/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import StoreData from './Store';
// import Timeline from './components/Timeline';
// import FollowButton from './components/FollowButton';
// import FeaturedUsers from './components/FeaturedUsers';

Vue.use(require('vue-moment'));
Vue.use(Vuex);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('get-data', require('./components/GetData.vue'));
Vue.component('timeline', require('./components/Timeline.vue'));
Vue.component('follow-button', require('./components/FollowButton.vue'));
Vue.component('featured-users', require('./components/FeaturedUsers.vue'));
// Vue.component('get-tweets', require('./components/GetTweets.vue'));

const store = new Vuex.Store(StoreData);

const app = new Vue({
    el: '#app',
    store,
    // components: {Timeline, FollowButton, FeaturedUsers},
});
