require('./bootstrap');

import Vue from 'vue';

Vue.component('inspection-component', require('./components/InspectionComponent.vue').default);

const app = new Vue({
    el: '#app',
});
