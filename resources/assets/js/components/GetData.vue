<template></template>
<script>
    import { mapActions, mapMutations } from 'vuex'

    export default {
        name: "GetData",
        props: ['current_user', 'user', 'current_route'],

        created(){
            this.setData({
                'currentRoute': this.current_route,
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