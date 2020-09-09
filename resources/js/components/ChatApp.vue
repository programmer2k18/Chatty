<template>

    <div class="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" @newMessage ="saveNewMessage"/>
        <contactsList :contacts="contacts" @selected="startConversationWith"/>
    </div>

</template>

<script>

    import Conversation from './Conversation'
    import ContactsList from './ContactsList'
    export default {
        props:{
            user:{
                type:Object,
                required:true
            }
        },
        data(){
            return {
                selectedContact:null,
                messages:[],
                contacts:[]
            }
        },
        mounted() {
            Echo.private('messages.'+this.user.id)
                .listen('NewMessage', (e)=>{
                    this.handleIncomingMessage(e.message);
                });
            axios.get('/contacts',)
                .then((response) => {
                    this.contacts = response.data
                });
        },
        methods:{
            startConversationWith(contact){
                this.updateUnreadCount(contact,true);
                axios.get('/conversation/'+contact.id)
                     .then((response) => {
                         this.messages = response.data;
                         this.selectedContact = contact
                     });
            },
            saveNewMessage(text){
                this.messages.push(text);
            },
            handleIncomingMessage(message){
                if (this.selectedContact && this.selectedContact.id == message.from ){
                    this.saveNewMessage(message);
                    return;
                }
                //console.log(message);
                //this.updateUnreadCount(message.fromContact,false);
            },
            updateUnreadCount(contact, reset){
                this.contacts = this.contacts.map((single)=>{
                    if (single.id !== contact.id)
                        return single;

                    if (reset)
                        single.unread = 0;
                    else
                        single.unread +=1;
                    return single;
                });
            }
        },
        components:{Conversation,ContactsList}
    }
</script>

<style>
    .chat-app{
        display: flex;
    }
</style>