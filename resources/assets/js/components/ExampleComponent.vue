<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <button class="form-control" v-on:click="post">Tsunahiki</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
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
            this.throttlePost = _.throttle(() => {
                axios.post('/works', {count: this.count});
                this.count = 0;
            }, 1000);
            console.log('Component mounted.')
        },
        
        methods: {
            post() {
                this.count++;
                this.throttlePost();
            }
        }
    }
</script>
