<template>

    <div class="container-fluid">
        <div class="row">
            <div class="smc-md-12">
                <h2>Free license support</h2>
            </div>
        </div>
        <div class="row">
            <div class="smc-md-6">
                <div class="snc_support_container">
                    <h3>Plugin documentation</h3>
                    <p>Every plugin contains a free documentation, which covers plugin installation and configuration instructions.</p>
                    <a href="https://web-data.io/docs/social-network-chat/" target="_blank"><div class="snc_btn_support">See documentation &raquo;</div></a>
                </div>
            </div>
            <div class="smc-md-6">
                <div class="snc_support_container">
                    <h3>Knowledge Base</h3>
                    <p>Our knowledge base covers all the frequently asked questions and other help documentations, and tips how you can make better use of your plugins.</p>
                    <a href="https://web-data.io/knowledge-base/" target="_blank"><div class="snc_btn_support">See knowledge base &raquo;</div></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="smc-md-6">
                <div class="snc_support_container">
                    <h3>Smart Chat</h3>
                    <p>Use Smart Chat to get answers to your questions.</p>
                    <a href="https://web-data.io/support/" target="_blank"><div class="snc_btn_support">Chat with Smart Chat &raquo;</div></a>
                </div>
            </div>
            <div class="smc-md-6">

            </div>
        </div>
    </div>

</template>

<script>

    export default {
        data: function(){
            return {
                variable: 'Support page'
            }
        }
    }

</script>

<style>
    .snc_support_container {
        background: #eee;
        padding: 15px;
        border-radius: 5px;
        margin: 5px 5px 35px 5px;
        -webkit-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        -moz-box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
        box-shadow: 0px 0px 5px 0px rgba(199,199,199,1);
            }
    
    .snc_btn_support {
        padding: 10px 15px;
        background: #111;
        color: #fff;
        border-radius: 5px;
        display: inline-block;
    }
</style>
