<template>

    <div class="composer">
        <textarea v-model="message" @keydown.enter ="send" placeholder="Message...."></textarea>
    </div>

</template>

<script>
    export default {
        data(){
          return{
            message:''
          };
        },
        methods:{
          send(e){
              e.preventDefault();
              if(this.message =='')
                  return;
              this.$emit('send', this.message);
              this.message= '';
          }
        }
    }
</script>

<style scoped lang="scss">

    .composer textarea{
        width: 97%;
        resize:none;
        margin:10px;
        border-radius: 3px;
        padding: 6px;
        border: 1px solid lightgray;
    }

</style>