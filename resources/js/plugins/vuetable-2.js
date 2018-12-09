import Vue from 'vue'
import * as Vuetable from "vuetable-2"

Vue.use(Vuetable);
Vue.component("vuetable", Vuetable.Vuetable);
Vue.component("vuetable-pagination", Vuetable.VueTablePagination);
Vue.component("vuetable-pagination-dropdown", Vuetable.VueTablePaginationDropDown);
Vue.component("vuetable-pagination-info", Vuetable.VueTablePaginationInfo);