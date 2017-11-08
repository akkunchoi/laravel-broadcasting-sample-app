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
//    import lodash from 'lodash';
    
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            post() {
//                _.throttle(() => {
                    axios.post('/works', {count: count});
//                }, 1000)
            }
        }
    }
</script>
