<template>
    <div class="alert alert-success fix-bottom" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        created(){
            if(this.message){
                this.flash(this.message)
           }
           window.events.$on('flash', (message) => {
            this.flash(message)
           });
        },
        data(){
            return {
                body: this.message,
                show: false
            }
        },
        methods: {
            flash: function(message){
                this.body = message
                this.show = true
                this.hide()
            },
            hide: function(){
                setTimeout(() => {
                    this.show = false
                }, 3000)
            }
        }
    }


</script>

<style>
    .fix-bottom{
        position:fixed;
        bottom:0;
        right:25px;
    }

</style>
