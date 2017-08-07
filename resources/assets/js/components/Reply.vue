<style>

</style>
<script>
    export default{
        props: ['attributes'],
        data(){
            return{
                editing:false,
                body: this.attributes.body,
            }
        },
        methods:{
            update(){
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                }).then(data => {
                    this.editing = false
                    flash('Updated!');
                }).catch(error => console.log(error));
            },
            destroy(){
                axios.delete('/replies/' + this.attributes.id).then(data => {
                    $(this.$el).fadeOut(300, ()=> {
                        flash('Your reply has been deleted.');
                    });
                });
            }
        }
    }
</script>
