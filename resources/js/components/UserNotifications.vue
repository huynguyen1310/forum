<template>
    <div class="dropdown show" v-if="notifications.length">
        <a class="btn btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span><i class="fas fa-bell"></i></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
            <div v-for="notification in notifications" :key="notification.id">
                <a class="dropdown-item" 
                :href="notification.data.link" 
                v-text="notification.data.message"
                @click="markAsRead(notification)"
                ></a>
            </div>
            

        </div>  
    </div>

</template>

<script>
export default {
    data() {
        return { notifications : [] }
    },

    created() {
        axios.get("/profile/" + window.App.user.name +  "/notifications")
            .then(res => this.notifications = res.data);
    },

    methods : {
        markAsRead(notification) {
            axios.delete("/profile/" + window.App.user.name +  "/notifications/" + notification.id);
        }
    }
}
</script>

<style>

</style>
