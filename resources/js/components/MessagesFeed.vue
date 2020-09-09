<template>

    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :class="message.to == contact.id?'messageSent':'messageReceived'" :key="message.id">
                <div class="text">
                    {{message.text}}
                    <span class="msgtime">{{message.sentAt}}</span>
                </div>
            </li>
        </ul>
    </div>

</template>

<script>
    export default {
        props:{
            contact:{
                type:Object
            },
            messages:{
                type: Array,
                required: true
            }
        },
        methods:{
            scrollToButton(){
                setTimeout(()=>{
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                },30);
            }
        },
        watch:{
            contact(){
                this.scrollToButton();
            },
            messages(){
                this.scrollToButton();
            }
        }
    }
</script>

<style scoped lang="scss">

    .feed{
        overflow-y:scroll;
        overflow-x:hidden;
        height: 100%;
        max-height: 420px;
        background: #f7f7f7;

        ul{
            list-style-type: none;
            padding: 5px;

            li{
                 margin:10px 0px;
                 width: 100%;

                .text{
                    display: inline-block;
                    max-width: 310px;
                    padding: 10px;
                    border-radius:9px;
                    position: relative;

                    .msgtime{
                        position: absolute;
                        bottom: 2px;
                        right: 2px;
                        font-weight: lighter;
                        font-size: 7px;
                    }

                }
                &.messageSent{
                    text-align: left;
                    .text{
                        background: #3691dc80;
                    }
                }
                &.messageReceived{
                    text-align: right;
                    .text{
                       background: #adb5bd;
                    }

                 }

            }
        }
    }

</style>