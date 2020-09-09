<template>
    <div class="conversation">
        <h1>{{contact ? contact.name:'Select a Contact'}}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>

</template>

<script>

    import MessagesFeed from './MessagesFeed'
    import MessageComposer from './MessageComposer'
    export default {
        props:{
            contact:{
                type:Object,
                default:null
            },
            messages:{
                type:Array,
                default:null
            }
        },
        methods:{
            sendMessage(text){
                if (! this.contact)
                    return;
                axios.post('/conversation/send',{
                    contact_id: this.contact.id,
                    text:text
                }).then((response) =>{
                    this.$emit('newMessage', response.data);
                })
            }
        },
        components:{MessagesFeed,MessageComposer}

    }
</script>

<style scoped  lang="scss">
    .conversation{
        display: flex;
        flex: 5;
        flex-direction: column;
        justify-content: space-between;

        h1{
            font-size: 18px;
            padding: 10px;
            margin: 0px;
            border-bottom: 1px solid lightgray;
            font-weight: bold;
        }
    }


</style>