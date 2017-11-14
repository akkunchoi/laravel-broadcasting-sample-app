<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <div class="clap-area">
                    <button class="clap-target" v-on:click="post">👏</button>
                    <p class="clap-total">{{participants.total}}</p>
                </div>
                <div class="list-group" v-if="false">
                    <li class="list-group-item" v-for="p in participants.ranking" v-bind:style="style(p)" v-if="p.count">
                        <div class="row">
                            <div class="col-sm-8">
                                <span v-text="p.user.name"></span>
                            </div>
                            <div class="col-sm-4">
                                <span v-text="p.count"></span>
                            </div>
                        </div>
                    </li>
                </div>                
            </div>
            
            <div class="col-xs-9" style="text-align: left">
                <form class="form-inline" v-on:submit="postMessage">
                    <div class="form-group">
                        You are 
                        <input type="text" class="form-control user-name" v-model="user.name" v-on:keyup="updateUserName" />
                        <input type="text" class="form-control user-name" v-model="message" placeholder="Input your comment"/>
                        <button type="submit" class="btn btn-default" :disabled="sending" :class="{disabled: sending}">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                    </div>
                </form>
                <div class="list-group">
                    <li class="list-group-item" v-for="m in participants.messages">
                        <div class="row">
                            <div class="col-xs-4">
                                <span v-text="m.user.name"></span>
                            </div>
                            <div class="col-xs-8">
                                <span v-text="m.text"></span>
                            </div>
                        </div>
                    </li>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    
    export default {
        mounted() {
            this.count = 0;
            this.delay = 500;
            this.throttlePost = _.throttle(() => {
                axios.post('/works', {count: this.count});
                this.count = 0;
            }, this.delay);
            this.throttleUpdateUserName = _.throttle(() => {
                if (this.user.name) {
                    axios.put('/users/' + this.user.id, {name: this.user.name})
                }
            }, this.delay);
        },
        data() {
            return {
                message: '',
                sending: false,
            }
        },
        props: ['participants', 'user'],
        methods: {
            style(p) {
                if (this.user.id === p.user.id) {
                    let bg = '#FEE';
                    return {
                        backgroundColor: bg
                    }
                }
            },
            post() {
                this.count++;
                this.throttlePost();
            },
            updateUserName() {
                this.throttleUpdateUserName();
            },
            postMessage(e) {
                e.preventDefault();
                if (this.sending || !this.message) {
                    return false;
                }
                this.sending = true;
                axios.post('/messages', {text: this.message}).then(() => {
                    this.sending = false;
                    this.message = '';
                }, () => {
                    this.sending = false;
                    this.message = '';
                });
                return false;
            }
        }
    }
</script>
