<template>

    <div class="container-fluid">
        <div class="row" style="padding: 20px 0px;">
            <div class="smc-md-4">
                <a class="snc_support_link" href="https://web-data.io/docs/social-network-chat/" target="_blank">
                    <div class="snc_support_btn green">
                        Plugin Documentation &raquo;
                    </div>
                </a>
            </div>
            <div class="smc-md-4">
                <a class="snc_support_link" href="https://web-data.io/knowledge-base/" target="_blank">
                    <div class="snc_support_btn blue">
                        Knowledge Base &raquo;
                    </div>
                </a>
            </div>
            <div class="smc-md-4">
                <a class="snc_support_link" href="https://web-data.io/support/submit-ticket/" target="_blank">
                    <div class="snc_support_btn lightblue">
                        Support Ticket System &raquo;
                    </div>
                </a>
            </div>            
        </div>
        <div class="row">
            <div class="smc-md-12">
                <h2>Premium license support</h2>
                <p>Use the buttons above to find your answer on our documentation, or use the contact form below to submit your question in to our support system.<br> Our support staff will review your support request in the next 24 hours and reply to the given e-mail address.</p>
            </div>
        </div>

        <div class="row">
            <div class="smc-md-6">
                <h2>Support Form</h2>
                <div style="border: 2px solid #009900; padding: 10px; margin: 10px 0px;"><b>Before posting a support request, make sure no other plugins or themes are causing your issues, by disabling all the other plugins and selecting one of the WordPress default themes!</b></div>
                <p>* All fields are required!</p>
                <input class="snc_input_class" type="text" v-model="input_name" placeholder="Your name*">
                <input class="snc_input_class" type="text" v-model="input_email" placeholder="E-mail*">
                <input class="snc_input_class" type="text" v-model="input_title" placeholder="Title*">
                
                <select class="snc_input_select" v-model="input_request_type">
                    <option disabled value="">Please select one*</option>
                    <option value="support_request">Support request</option>
                    <option value="feature_request">Feature request</option>
                </select>
                
                <textarea class="snc_textarea_class" v-model="input_ticket" placeholder="Your request*"></textarea>
                
                <div id="snc_error_wrap">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="wb-md-12">
                                
                                <div class="snc_error" v-if="this.input_name_error">
                                    Error, please fill your username!
                                </div>
                                
                                <div class="snc_error" v-if="this.input_email_error">
                                    Error, please check your email!
                                </div>
                                
                                <div class="snc_error" v-if="this.input_title_error">
                                    Error, please fill the title!
                                </div>
                                
                                <div class="snc_error" v-if="this.input_ticket_error">
                                    Error, please fill the request!
                                </div>

                                <div class="snc_lahetys_ok" v-if="this.snc_lahetys_ok">
                                    Thank you for your support request. Our support agent will review your request shortly, and will contact you via email!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="snc_support_btn_send" class="snc_support_btn send" @click="submitToTicketSystem()">{{ input_submit_text }}</div>
            </div>
            <div class="smc-md-6">
                <h2>Support Tickets History</h2>
                <ul class="snc_tickets_ul" v-for="(ticket, index) in this.tickets" v-if="index < 5">
                    <li>{{ ticket }}</li>
                </ul>
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
                input_submit_text: 'Send your request to the support ticket system',
                input_name: '',
                input_email: '',
                input_title: '',
                input_ticket: '',
                input_request_type: '',
                tickets: [],
                loader: false,
                clickAble: true,
                input_name_error: false,
                input_email_error: false,
                input_title_error: false,
                input_ticket_error: false,
                snc_lahetys_ok: false
            }
        },
        created: function() {
            this.getLoginDetails();
            this.getTickets();
        },
        methods: {
            getLoginDetails() {
                let data = {
                    'action': 'getSncLoginCredentials',
                    'sendData': ''
                };

                let vm = this;

                let url = wb_sncAdminAjax.ajaxurl;

                axios.post(url, Qs.stringify(data))
                        .then(function (response) {
                            if(response.data != '') {
                                vm.input_name = response.data[0];
                                vm.input_email = response.data[1];
                            }
 
                        }).catch(function (error) {
                            console.log(error)
                    });
            },
            getTickets() {
                let data = {
                    'action': 'getSncTickets',
                    'sendData': ''
                };

                let vm = this;

                let url = wb_sncAdminAjax.ajaxurl;

                axios.post(url, Qs.stringify(data))
                        .then(function (response) {
                            
                            if(response.data != '') {
                                for (let ticket of response.data) {
                                    vm.tickets.push(ticket);
                                }
                            }
 
                        }).catch(function (error) {
                            console.log(error)
                    });
            },
            submitToTicketSystem() {

                if(!this.clickAble) return;

                let error = false;

                this.input_name_error = false;
                this.input_email_error = false;
                this.input_title_error = false;
                this.input_ticket_error = false;

                if(typeof this.input_name == 'undefined' || this.input_name == '') {
                    error = true;
                    this.input_name_error = true;
                }

                if(typeof this.input_title == 'undefined' || this.input_title == '') {
                    error = true;
                    this.input_title_error = true;
                }

                if(typeof this.input_ticket == 'undefined' || this.input_ticket == '') {
                    error = true;
                    this.input_ticket_error = true;
                }

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

                if(!error || error) {
                    let obj = {}

                    obj['input_name'] = this.input_name;
                    obj['input_title'] = this.input_title;
                    obj['input_ticket'] = this.input_ticket;
                    obj['input_email'] = this.input_email;

                    let sendDataAjax = JSON.stringify(obj);

                    let data = {
                        'action': 'sendSncRequest',
                        'sendData': sendDataAjax
                    };

                    let vm = this;

                    let url = wb_sncAdminAjax.ajaxurl;

                    this.loader = true;

                    this.clickAble = false;

                    if(typeof document.getElementById('snc_support_btn_send') != 'undefined') {
                        let element = document.getElementById("snc_support_btn_send");
                        element.classList.add("snc_not_allowed");

                        this.input_submit_text = 'Sending the request, please wait...';
                    }
                    
                    axios.post(url, Qs.stringify(data))
                        .then(function (response) {                        
                            vm.loader = false;
                            vm.snc_lahetys_ok = true;

                            vm.input_title = '';
                            vm.input_ticket = '';

                            vm.clickAble = true;

                            if(typeof document.getElementById('snc_support_btn_send') != 'undefined') {
                                let element = document.getElementById("snc_support_btn_send");
                                element.classList.remove("snc_not_allowed");

                                vm.input_submit_text = 'Send your request to the support ticket system';
                            }

                            setTimeout(function () {
                                vm.snc_lahetys_ok = false;
                            }, 5000);

                        }).catch(function (error) {
                            console.log(error)
                    });
                }
            }
        }
    }

</script>

<style>
    input.snc_input_class {
        width: 100%;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #999;
        background: #fff;
        margin-bottom: 15px;
        -webkit-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        -moz-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
    }

    select.snc_input_select {
        width: 100%;
        height: 50px;
        padding: 0px 15px;
        border-radius: 5px;
        border: 1px solid #999;
        background: #fff;
        margin-bottom: 15px;
    }

    option:checked { color: red; }

    textarea.snc_textarea_class {
        width: 100%;
        height: 200px;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #999;
        background: #fff;
        margin-bottom: 15px;
        -webkit-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        -moz-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
    }

    .snc_support_btn {
        padding: 20px;
        border-radius: 5px;
        color: #fff;
        text-align: center;
        font-weight: 600;
        text-transform: uppercase;
        transform: scale(1.0);
        transition: all .2s;
        cursor: pointer;
    }

    .snc_support_btn:hover {
        transform: scale(1.03);
    }

    .snc_support_link{
        text-decoration: none !important;
        color: #fff;
    }

    .snc_support_btn.green {
        background: #77be06;
    }

    .snc_support_btn.blue {
        background: #1b6dcd;
    }

    .snc_support_btn.orange {
        background: #ea5400;
    }

    .snc_support_btn.lightblue {
        background: #1ba6cd;
    }

    .snc_support_btn.send {
        background: #77be06;
        width: 100%;
    }

    .snc_lahetys_ok,
    .snc_error {
        border: 2px solid #ff0000;
        padding: 10px;
        margin: 15px 0px;
        color: #ff0000;
        background: #f2f2f2;
    }

    .snc_lahetys_ok {
        border: 2px solid #008800;
        color: #111;
    }

    .snc_not_allowed {
        background: #999 !important;
        cursor: not-allowed !important;
    }

    ul.snc_tickets_ul li {
        list-style-type: circle;
        margin-left: 15px;
    }
</style>
