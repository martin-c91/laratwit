<template>
    <div>
        <button v-if="user.isFollowing" class="btn btn-secondary" v-on:click="postUnFollow({user})">UnFollow</button>
        <button v-else class="btn btn-primary" v-on:click="postFollow({user})">Follow</button>
    </div>
</template>

<script>
    import {mapActions} from 'vuex'
    import {sync} from 'vuex-pathify';

    export default {
        computed: {
            ...sync(['user'])
        },
        methods: {
            ...mapActions(['postFollow', 'postUnFollow']),
        },
    }
</script>
