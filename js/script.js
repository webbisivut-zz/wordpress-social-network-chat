import Vue from 'vue'
//import ProSupport from './components/SupportPro.vue'
import Support from './components/Support.vue'
//import License from './components/License.vue'
//import Refund from './components/Refund.vue'

window.onload = function () {
    if(document.getElementById('settings_page_support_pro') != null) {
        new Vue({
            el: '#settings_page_support_pro',
            render: h => h(ProSupport)
        });
    }

    if(document.getElementById('settings_page_support') != null) {
        new Vue({
            el: '#settings_page_support',
            render: h => h(Support)
        });
    }

    if(document.getElementById('settings_page_license') != null) {
        new Vue({
            el: '#settings_page_license',
            render: h => h(License)
        });
    }

    if(document.getElementById('settings_page_refund') != null) {
        new Vue({
            el: '#settings_page_refund',
            render: h => h(Refund)
        });
    }
}