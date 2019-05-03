<template>
    <div>
        <div class="form-group mt-4" v-if="signedIn">
            <textarea name="body" id="" class="form-control" placeholder="Have somethin to say ?" required v-model="body"></textarea>
            <button class="btn btn-success mt-2" @click="addReply">Post</button>
        </div>
        
        <p class="text-center" v-else>Please <a href="/login" @click="addReply">sign in</a> to participate in this discussion.</p>
    </div>
    
</template>

<script>
export default {
    data() {
        return {
            body : '',
        }
    },
    methods : {
        addReply() {
            axios.post(location.pathname + '/replies' , { body : this.body })
                .catch(error => {
                    flash(error.response.data , 'danger');
                })
                .then(({data}) => {
                    this.body = '';

                    flash('Your reply has been posted');

                    this.$emit('created', data);
                })
        }
    },
    computed : {
        signedIn() {
            return window.App.signedIn;
        }
    }
}
</script>

<style>

</style>
