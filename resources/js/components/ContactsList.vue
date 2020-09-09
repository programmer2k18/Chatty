<template>

    <div class="contacts-list">
        <ul>
            <li v-for="(contact) in sortedContacts" :key="contact.id"
                @click="selectContact(contact)" :class="{'selected':contact==selected}">

                <div class="avatar">
                    <img :src="contact.image" :alt="contact.name">

                </div>

                <div class="contact">
                    <p class="name">{{contact.name}}</p>
                    <p class="email">{{contact.email}}</p>
                </div>
                <span class="unread" v-if="contact.unread">{{contact.unread}}</span>
            </li>
        </ul>
    </div>

</template>

<script>
    export default {

        props:{
            contacts:{
                type:Array,
                default:{}
            }
        },
        data(){
            return {
              selected: this.contacts.length?this.contacts[0]:null
            };
        },
        methods:{
            selectContact(contact){
                this.selected = contact;
                this.$emit('selected', contact);
            }
        },
        computed:{
            sortedContacts(){
                return _.sortBy(this.contacts,[(contact)=>{
                    if (contact == this.selected)
                        return Infinity;
                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>

<style scoped lang="scss">
    .contacts-list{
        flex: 2;
        max-height: 515px;
        border-left: 1.5px solid #adb5bd;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    ul{
       list-style-type: none;
       padding-left: 0;

       li{
           display:flex;
           padding:2px;
           height:80px;
           position:relative;
           border-bottom: 1.5px solid #adb5bd;
           cursor:pointer;

           &.selected{
            background: #adb5bd;
           }

           span.unread{
               background: #5cd08d;
               color: #f7f7f7;
               position: absolute;
               top: 20px;
               right: 12px;
               display: flex;
               font-weight: bolder;
               min-width:20px;
               justify-content:center;
               align-items:center;
               line-height: 20px;
               font-size: 15px;
               border-radius: 50%;
               padding:0px 4px;
           }
           .avatar{
               display:flex;
               flex:1;
               align-items:center;

               img{
                   max-height: 45px;
                   max-width: 45px;
                   border-radius: 50%;
                   margin: 0px auto;
               }
           }
           .contact{
               display:flex;
               flex: 3;
               overflow:hidden;
               flex-direction:column;
               justify-content:center;
               font-size: 14px;
               margin: 5px 0px -2px 0px;
               .name{
                   margin: 9px 0px -2px 0px;
                   font-weight:bold;
               }
           }
       }
    }

</style>