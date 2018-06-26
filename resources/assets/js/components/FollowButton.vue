<template>
    <div>
        {{user.isFollowing}}
        <button v-if="user.isFollowing" class="btn btn-secondary" v-on:click="postFollow(user)">UnFollow</button>
        <button v-else class="btn btn-primary" v-on:click="postFollow(user)">Follow</button>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        computed: {
            user(){
                return this.$store.getters.user;
            },
        },
        methods: {
            ...mapActions(['postFollow']),
        }
    }
</script>