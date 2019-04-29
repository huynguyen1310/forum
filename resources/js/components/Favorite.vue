<template>
    <button :class="classes" @click="toggle">
        <span><i class="fas fa-heart"></i></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
export default {
    props : ['reply'],
    data() {
        return {
            favoritesCount : this.reply.favoritesCount,
            isFavorited : this.reply.isFavorited
        }
    },
    computed : {
        classes() {
            return ['btn', this.isFavorited ? 'btn-primary' : 'btn-default']
        },
        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },
    methods : {
        toggle() {
            if(this.isFavorited){
                axios.delete(this.endpoint).catch(err =>{
                    console.log(err)
                });
                
                this.isFavorited = false;
                this.favoritesCount--;
            }else {
                axios.post(this.endpoint);

                this.isFavorited = true;
                this.favoritesCount++;
            }
        }
    }
}
</script>

<style>

</style>
