<template>
    <div class="container">
        <form>
            <div>
                You are 
                <input type="text" class="form-control user-name" v-model="user.name" v-on:keyup="updateUserName" />
            </div>
        </form>
        
        <div class="row">
            <div class="col-xs-6">
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
            <div class="col-xs-6">
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
            }, this.delay)
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
            }
        }
    }
</script>
