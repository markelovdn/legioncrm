import { createApp } from 'vue'
import ChangeStatusButton from './components/athletes/ChangeStatusButton'
import GetRouteCompetitorsExport from './components/competitors/GetRouteCompetitorsExport'
import CompetitorsIndex from './components/competitors/CompetitorsIndex'
import SearchHeaderInput from './components/SearchHeaderInput'

require('./bootstrap');

// export const eventEmitter = new Vue()

createApp({
    components: {
        ChangeStatusButton,
        GetRouteCompetitorsExport,
        CompetitorsIndex,
        SearchHeaderInput
    }
}).mount('#app')

// const app = new Vue({
//     el: '#app',
//
//     components: {
//         ChangeStatusButton,
//         GetRouteCompetitorsExport,
//         CompetitorsIndex,
//         SearchHeaderInput
//     }
// })
