<template>
    <form class="form-control" method="POST" action="" @submit.prevent="onSubmit">
        <div class="form-group">
            <label>Tweet</label>
            <textarea class="form-control" v-model="content" :placeholder="placeholder" rows="3"></textarea>
        </div>
        <div class="form-group float-right">
            <button class="btn btn-default" name="Submit">Submit</button>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                content: "",
                placeholder: "What's on your mind?",

            };
        },

        methods: {
            onSubmit(){
                console.log(this.content);
                this.content= "";
            }
        }
    }
</script>