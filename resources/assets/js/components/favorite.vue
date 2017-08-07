<template>
    <div>
        <button class="btn btn-default">
            <span class="glyphicon glyphicon-heart"></span>
            <span v-text='favoriteCount'></span>
        </button>
    </div>
</template>
<script>
    export default{
        props: ['reply'],
        data(){
            return{
                favoriteCount: this.reply.favorites_count
            }
        }
    }
</script>
