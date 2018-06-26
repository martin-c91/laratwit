<template></template>
<script>
    import { mapActions, mapMutations } from 'vuex'

    export default {
        name: "GetData",
        props: ['current_user', 'user'],

        mounted(){
            this.setData({
                'currentUser': this.current_user,
                'user': this.user,
            });
        },
        // computed: {
        //     ...mapState(['user', 'currentUser'])
        // },
        methods: {
            ...mapActions(['postFollow','postUnFollow']),
            ...mapMutations(['setData']),
        }
    }
</script>