<template>
    <div>
        <div class="form-group mt-4" v-if="signedIn">
            <wysiwyg name="body" v-model="body" placeholder="Have somethin to say ?" :shouldClear="completed"></wysiwyg>
            <button class="btn btn-success mt-2" @click="addReply">Post</button>
        </div>
        
        <p class="text-center" v-else>Please <a href="/login" @click="addReply">sign in</a> to participate in this discussion.</p>
    </div>
    
</template>

<script>
import "at.js";
import "jquery.caret";

export default {
    data() {
        return {
            body : '',
            completed : false
        }
    },
    mounted() {
        $('#body').atwho({
            at : "@",
            delay : 750,
            callbacks : {
                remoteFilter : function (query , callback) {
                    console.log('called');
                    $.getJSON("/api/users", { name : query },
                        function (usernames) {
                            callback(usernames);
                        }
                    );
                }
            }
        })
    },
    methods : {
        addReply() {
            axios.post(location.pathname + '/replies' , { body : this.body })
                .catch(error => {
                    flash(error.response.data , 'danger');
                })
                .then(({data}) => {
                    this.body = '';
                    this.completed = true;

                    flash('Your reply has been posted');

                    this.$emit('created', data);
                })
        }
    },
}
</script>

<style>

</style>
