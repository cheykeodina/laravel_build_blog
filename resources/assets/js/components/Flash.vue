<template>
    <div class="alert alert-success fix-bottom">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        data(){
            return {
                body: "This is message"
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
