<template>
    <!--<div>-->
        <!--hello ...-->
        <!--{{currentRoute}}-->
        <!--...bye-->

        <!--<button @click="test">Test Fucntion</button>-->
    <!--</div>-->
</template>
<script>
    import {mapActions, mapMutations} from 'vuex';
    import {sync} from 'vuex-pathify';

    export default {
        name: "GetData",
        props: ['prop_current_user', 'prop_user', 'prop_current_route'],

        created() {
            this.currentRoute = this.prop_current_route;
            this.user = this.prop_user;
            this.currentUser = this.prop_current_user;
            // 'currentUser': this.prop_current_user,
            // 'user': this.prop_user,
            // this.setData();
        },
        computed: {
            ...sync(
                // ...this.man
                ['currentRoute', 'user', 'currentUser', 'newContent']
            ),
        },
        mounted() {
            // console.log(this.man);
            // this.test();
            // console.log(this.currentRoute);
            // console.log(this.$store.get('currentRoute'));
        },
        methods: {
            // test: function () {
            //     this.currentRoute = "voila";
            //     console.log('test clicked');
            // },
            ...mapActions(['postFollow', 'postUnFollow']),
            // ...mapMutations(['SET_USER']),
        }
    }
</script>
