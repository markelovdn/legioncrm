import Vue from 'vue'
import ChangeStatusButton from './components/athletes/ChangeStatusButton'
import GetRouteCompetitorsExport from './components/competitors/GetRouteCompetitorsExport'
import CompetitorsIndex from './components/competitors/CompetitorsIndex'
import SearchHeaderInput from './components/SearchHeaderInput'

require('./bootstrap');

export const eventEmitter = new Vue()

const app = new Vue({
    el: '#app',

    components: {
        ChangeStatusButton,
        GetRouteCompetitorsExport,
        CompetitorsIndex,
        SearchHeaderInput
    }
})






// window.Vue = require('vue').default;
//
//
// // const files = require.context('./', true, /\.vue$/i)
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//
// Vue.component('change-status-button', require('./components/athletes/change-status-button').default);
// Vue.component('get-route-competitors-export', require('./components/athletes/get-route-competitors-export').default);
// Vue.component('input-date', require('./components/input-date').default);
// Vue.component('competitors-page', require('./components/competitors/competitors-page').default);
//     Vue.component('competitors-list', require('./components/competitors/competitors-list').default);
//     Vue.component('coach-select', require('./components/competitors/filters/coach-select').default);
// Vue.component('modal-result', require('./components/competitors/modal-result').default);
// Vue.component('search-header-input', require('./components/search-header-input').default);
//
//
// const app = new Vue({
//     el: '#app',
// });
