<template>

    <div class="container-fluid">
        <div class="row">
            <div class="smc-md-12">
                <div class="snc_support_container">
                    <h3>Please enter your license key below to register it:</h3>
                    <input class="snc_input_class" type="text" v-model="input_license" placeholder="License key*">
                    <div v-if="this.registered" id="snc_btn_unregister_license" class="snc_btn_support_unregister" @click="unregisterLicense()">Unregister license &raquo;</div>
                    <div v-else id="snc_btn_register_license" class="snc_btn_support" @click="registerLicense()">Register license &raquo;</div>

                    <div id="snc_license_ok" class="snc_license_ok">Thank you! Your request has been completed succesfully!</div>
                    <div id="snc_license_error" class="snc_license_error">There was an error while delivering your request. Message: {{ api_error }}. If you need any assistance, please contact: <a href="license@web-data.io">license@web-data.io</a></div>
                    
                    <div v-if="this.loader" class="ajax_loader"></div>

                    <div v-if="!this.loader" style="display: block; width: 100%; margin: 10px 0px;">
                        <div style="background: #a8f9a7; border: 2px solid #009900; padding: 10px; display: inline-block; margin: 10px 0px;" v-if="this.registered">License is activated.</div>
                        <div style="border: 2px solid #ff0000; padding: 10px; display: inline-block; margin: 10px 0px;" v-else>License is not activated.</div>
                    </div>
                </div>

                <div class="snc_support_container">
                    <h3>E-mail to retrieve the license key</h3>
                    <p>If you have lost the license key, please enter e-mail address which was used to purchase the license, <br>and we will send the license code to your e-mail.</p>
                    <p>Email will be delivered only if we can find matching email from our database.</p>
                    <input class="snc_input_class" type="text" v-model="input_email" placeholder="E-mail address*">
                    <div id="snc_btn_retrieve_license" class="snc_btn_support" @click="retrieveLicense()">Retrieve license key &raquo;</div>

                    <div v-if="this.loader_email" class="ajax_loader"></div>

                    <div id="snc_license_retrieve_ok" class="snc_license_ok">Your license key has been sent to the given e-mail!</div>
                    <div id="snc_license_retrieve_error" class="snc_license_error">There was an error. Please contact: <a href="license@web-data.io">license@web-data.io</a></div>
                    <div class="snc_license_error_email" v-if="input_email_error">Error! Please check your e-mail address.</div>

                </div>
            </div>
        </div>
        
    </div>

</template>

<script>
    import axios from 'axios'
    import Qs from 'qs'

    export default {
        data: function(){
            return {
                input_license: '',
                input_email: '',
                api_error: 'n/a',
                input_email_error: false,
                registered: false,
                loader: false,
                loader_email: false
            }
        },
        created: function() {
            this.getLicenseFromDatabase();
        },
        methods: {
            getLicenseFromDatabase() {
                let data = {
                    'action': 'getSncLicense',
                    'sendData': ''
                };

                let vm = this;

                let url = wb_sncAdminAjax.ajaxurl;

                if(typeof document.getElementById('snc_btn_register_license') != 'undefined' && document.getElementById('snc_btn_register_license') != null) {
                    let element = document.getElementById('snc_btn_register_license');
                    element.classList.add("submit_loading");
                }

                this.loader = true;

                axios.post(url, Qs.stringify(data))
                        .then(function (response) {

                            if(response.data != '') {
                                vm.input_license = response.data;
                                vm.registered = true;
                            }

                            vm.loader = false;

                        }).catch(function (error) {
                            vm.api_error = error
                            console.log(error);
                    });
            },
            registerLicense() {
                let obj = {}

                obj['input_license'] = this.input_license;

                let sendDataAjax = JSON.stringify(obj);

                let data = {
                    'action': 'registerSncLicense',
                    'sendData': sendDataAjax
                };

                this.loader = true;

                let vm = this;

                let url = wb_sncAdminAjax.ajaxurl;

                if(typeof document.getElementById('snc_btn_register_license') != 'undefined' && document.getElementById('snc_btn_register_license') != null) {
                    let element = document.getElementById('snc_btn_register_license');
                    element.classList.add("submit_loading");
                }

                axios.post(url, Qs.stringify(data))
                        .then(function (response) {

                            if(typeof document.getElementById('snc_btn_register_license') != 'undefined' && document.getElementById('snc_btn_register_license') != null) {
                                let element = document.getElementById('snc_btn_register_license');
                                element.classList.remove("submit_loading");
                            }

                            if(response.data == 200) {
                                vm.registered = true;

                                if(typeof document.getElementById('snc_license_ok') != 'undefined') {
                                    document.getElementById('snc_license_ok').style.display = 'block';

                                    setTimeout(() => {
                                        document.getElementById('snc_license_ok').style.display = 'none';
                                        location.reload();
                                    }, 2000);
                                }
                            } else {
                                vm.api_error = response.data;
                                document.getElementById('snc_license_error').style.display = 'block';

                                setTimeout(() => {
                                    vm.api_error = 'n/a';
                                    document.getElementById('snc_license_error').style.display = 'none';
                                }, 5000);
                            }

                            vm.loader = false;
                        }).catch(function (error) {
                            console.log(error)
                            if(typeof document.getElementById('snc_license_error') != 'undefined') {
                                document.getElementById('snc_license_error').style.display = 'block';

                                setTimeout(() => {
                                    document.getElementById('snc_license_error').style.display = 'none';
                                }, 5000);
                            }
                    });
            },
            unregisterLicense() {
                let obj = {}

                obj['input_license'] = this.input_license;

                let sendDataAjax = JSON.stringify(obj);

                let data = {
                    'action': 'unregisterSncLicense',
                    'sendData': sendDataAjax
                };

                this.loader = true;

                let vm = this;

                let url = wb_sncAdminAjax.ajaxurl;

                if(typeof document.getElementById('snc_btn_unregister_license') != 'undefined' && document.getElementById('snc_btn_unregister_license') != null) {
                    let element = document.getElementById('snc_btn_unregister_license');
                    element.classList.add("submit_loading");
                }

                axios.post(url, Qs.stringify(data))
                        .then(function (response) {

                            if(typeof document.getElementById('snc_btn_unregister_license') != 'undefined' && document.getElementById('snc_btn_unregister_license') != null) {
                                let element = document.getElementById('snc_btn_unregister_license');
                                element.classList.remove("submit_loading");
                            }

                            if(response.data == 200) {
                                if(typeof document.getElementById('snc_license_ok') != 'undefined') {
                                    document.getElementById('snc_license_ok').style.display = 'block';

                                    setTimeout(() => {
                                        document.getElementById('snc_license_ok').style.display = 'none';
                                        location.reload();
                                    }, 2000);
                                }
                            } else {
                                document.getElementById('snc_license_error').style.display = 'block';

                                setTimeout(() => {
                                    document.getElementById('snc_license_error').style.display = 'none';
                                }, 5000);
                            }

                            vm.registered = false;
                            vm.input_license = '';
                            vm.loader = false;
                        }).catch(function (error) {
                            console.log(error)
                            if(typeof document.getElementById('snc_license_error') != 'undefined') {
                                document.getElementById('snc_license_error').style.display = 'block';

                                setTimeout(() => {
                                    document.getElementById('snc_license_error').style.display = 'none';
                                }, 4000);
                            }
                    });
            },
            retrieveLicense() {
                let obj = {}

                this.input_email_error = false;
                let error = false;

                if(typeof this.input_email == 'undefined' || this.input_email == '') {
                    error = true;
                    this.input_email_error = true;
                } else {
                    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    let test = regex.test(this.input_email);

                    if(test == false) {
                        error = true;
                        this.input_email_error = true;
                    }
                }

                if(error) return;

                this.loader_email = true;

                obj['input_email'] = this.input_email;

                let sendDataAjax = JSON.stringify(obj);

                let data = {
                    'action': 'retrieveSncLicense',
                    'sendData': sendDataAjax
                };

                let vm = this;

                let url = wb_sncAdminAjax.ajaxurl;

                if(typeof document.getElementById('snc_btn_retrieve_license') != 'undefined' && document.getElementById('snc_btn_retrieve_license') != null) {
                    let element = document.getElementById('snc_btn_retrieve_license');
                    element.classList.add("submit_loading");
                }

                axios.post(url, Qs.stringify(data))
                        .then(function (response) {

                            if(typeof document.getElementById('snc_btn_retrieve_license') != 'undefined' && document.getElementById('snc_btn_retrieve_license') != null) {
                                let element = document.getElementById('snc_btn_retrieve_license');
                                element.classList.remove("submit_loading");
                            }

                            if(response.data == 200) {
                                if(typeof document.getElementById('snc_license_retrieve_ok') != 'undefined') {
                                    document.getElementById('snc_license_retrieve_ok').style.display = 'block';

                                    setTimeout(() => {
                                        document.getElementById('snc_license_retrieve_ok').style.display = 'none';
                                    }, 4000);
                                }
                            } else {
                                document.getElementById('snc_license_retrieve_error').style.display = 'block';

                                setTimeout(() => {
                                    document.getElementById('snc_license_retrieve_error').style.display = 'none';
                                }, 5000);
                            }

                            vm.loader_email = false;
 
                        }).catch(function (error) {
                            console.log(error)
                            if(typeof document.getElementById('snc_license_retrieve_error') != 'undefined') {
                                document.getElementById('snc_license_retrieve_error').style.display = 'block';

                                setTimeout(() => {
                                    document.getElementById('snc_license_retrieve_error').style.display = 'none';
                                }, 4000);
                            }
                    });
            }
        }
    }

</script>

<style>
    input.snc_input_class {
        width: 300px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #999;
        background: #fff;
        margin-bottom: 15px;
        -webkit-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        -moz-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
    }

    .snc_support_container {
        background: #eee;
        padding: 15px;
        border-radius: 5px;
        margin: 5px 5px 35px 5px;
        -webkit-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        -moz-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
    }
    
    .snc_btn_support_unregister,
    .snc_btn_support {
        padding: 10px 15px;
        background: #111;
        color: #fff;
        border-radius: 5px;
        display: inline-block;
        cursor: pointer;
    }

    .snc_btn_support_unregister {
        background: #ff0000;
        color: #fff;
    }

    .snc_license_error_email,
    .snc_license_retrieve_ok,
    .snc_license_retrieve_error,
    .snc_license_error,
    .snc_license_ok {
        padding: 10px;
        border: 2px solid #006600;
        margin: 5px 0px;
        display: none;
    }

    .snc_license_error_email,
    .snc_license_retrieve_error,
    .snc_license_error {
        border: 2px solid #ff0000;
    }

    .snc_license_error_email {
        display: block;
    }

    .submit_loading {
        background: #999;
        cursor: not-allowed;
    }
</style>
