import Vue from 'vue'
import {ServerTable, ClientTable, Event} from 'vue-tables-2'

//Vue.use(ClientTable, [options = {}], [useVuex = false], [theme = 'bootstrap4'], [template = 'default']);
Vue.use(ClientTable, {}, false, 'bootstrap4');
Vue.use(ServerTable, {}, false, 'bootstrap4');