<script>
import Replies from "../components/Replies";
import SubscribeButton from "../components/SubscribeButton";

export default {
    components : { Replies , SubscribeButton },
    props : ['thread'],
    data() {
        return {
            repliesCount : this.thread.replies_count,
            locked  : this.thread.locked
        }
    },
    methods : {
        toggleLock() {
            axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);
            
            this.locked = !this.locked;
        } 
    }
}
</script>
