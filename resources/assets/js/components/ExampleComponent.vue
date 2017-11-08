<template>
    <div class="container">
        <div>
            <button class="form-control" v-on:click="post">Tsunahiki</button>
        </div>
        <p>
            You are {{user.name}}
        </p>
        <div class="list-group">
            <li class="list-group-item" v-for="p in participants.ranking" v-bind:style="style(p)">
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
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    
    export default {
        mounted() {
            this.count = 0;
            this.throttlePost = _.throttle(() => {
                axios.post('/works', {count: this.count});
                this.count = 0;
            }, 1000);
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
            }
        }
    }
</script>
