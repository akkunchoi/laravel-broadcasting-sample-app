<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <button class="form-control" v-on:click="post">Tsunahiki</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            post: function() {
                axios.post('/works')
            }
        }
    }
</script>
