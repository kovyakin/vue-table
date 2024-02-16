import {createApp} from "vue/dist/vue.esm-bundler.js";

import DataTable from '@/components/DataTable.vue';
const datatable = createApp({});

datatable.component('table-component', DataTable);

export function table(id){
    if (document.getElementById(id) !== null) {
      datatable.mount("#"+id)
    }
}
