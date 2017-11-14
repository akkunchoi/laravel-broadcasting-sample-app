/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import _ from 'lodash';

class ParticipantRanking {
    constructor() {
        this.userCounts = {};
        this.ranking = [];
    }
    count(user, count) {
        let id = user.id;
        if ( ! (id in this.userCounts) ) {
            this.userCounts[id] = 0;
            this.ranking.push({user: user, count: 0});
        }
        this.userCounts[id] += count || 0;
        this.calcRanking();
    }
    update(user) {
        _.forEach(this.ranking, (userWithCount) => {
            if (userWithCount.user.id === user.id) {
                userWithCount.user.name = user.name;
            }
        });
    }
    calcRanking() {
        _.forEach(this.ranking, (userWithCount) => {
            userWithCount.count = this.userCounts[userWithCount.user.id];
        });
        this.ranking.sort((a, b) => {
            // desc sort
            return b.count - a.count;
        });
    }
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let participants = new ParticipantRanking();
Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    data: {
        participants: participants,
        user: Laravel.user
    }
});

const channel = window.Echo.join('hoge')
    .here(() => {
        console.log('here');
        participants.count(Laravel.user, 0);
    })
    .joining(() => {
        console.log('joining');
    })
    .leaving(() => {
        console.log('leaving');
    })
    .listen('WorkCreated', (e) => {
        participants.count(e.user, e.count);
    })
    .listen('UserUpdated', (e) => {
        participants.update(e.user);
    });

console.log(channel);

