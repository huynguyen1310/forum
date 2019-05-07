<template>
    <div class="mt-4 card">
        <div :id="'reply-' + id" class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profile/' + data.owner.name" v-text="data.owner.name"></a> said <span v-text="ago"></span>
                </h5>

                    <div v-if="signedIn">
                        <favorite :reply="data"></favorite>                    
                    </div>    
            </div>
                
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea name="body" id="" class="form-control" v-model="body" required></textarea>

                        <button class="btn btn-sm btn-link">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                    </div>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>

            <div class="card-footer level" >
                <div v-if="authorize('updateReply', reply)">
                    <button class="btn btn-primary btn-sm mr-1" @click="editing = true">Edit</button>
                    <button class="btn btn-danger btn-sm mr-1" @click="destroy">Delete</button>
                </div>
                
                <i :class="classes"  @click="markBestReply" style="cursor:pointer"></i>

            </div>
    </div>
</template>


<script>
import Favorite from './Favorite';
import moment from 'moment'
export default {
    props : ['data'],
    components : {
        Favorite
    },
    data() {
        return {
            editing : false,
            id : this.data.id,
            body : this.data.body,
            isBest : this.data.isBest,
            reply : this.data,
        }
    },
    computed : {
        ago() {
            return moment(this.data.created_at).fromNow();
        },
        classes() {
            return ['fa-star mr-1 ml-auto', this.isBest ? 'fas text-success' : 'far']
        },
    },
    created() {
        window.events.$on('best-reply-selected' , id =>{
            this.isBest = (this.id === id);
        });
    },
    methods : {
        update() {
            axios.patch('/replies/' + this.data.id, {
                body : this.body
            })
                .catch(error => flash(error.response.data , 'danger'));

            this.editing = false;
        },
        destroy() {
            axios.delete('/replies/' + this.data.id);

            this.$emit('deleted' , this.data.id);
            
        },
        markBestReply() {
            axios.post('/replies/' + this.data.id + '/best');

            window.events.$emit('best-reply-selected' , this.id);
        }

    }
}
</script>
