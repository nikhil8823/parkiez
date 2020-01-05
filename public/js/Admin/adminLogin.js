$(document).ready(function(){
   
    validator = $("#admin_login_form").validate({
        wrapper: "div",
        rules: {
            email: {
                required: true,
                email:true
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: 'Please enter Email Address',
                email: 'Email address is not valid',
            },
            password: {
                required: 'Please enter password',
            }
        }
    });
    
    validator = $("#forgotPasswordForm").validate({
        wrapper: "div",
        rules: {
            email: {
                required: true,
                email:true,
                remote: {
                    url: "/admin/isEmailExist",
                    type: "post",
                    data: {
                        'email': function () {
                            return ($('#email').val());
                        }},
                    async: true
                }
            }        
        },
        messages: {
            email: {
                required: 'Please enter registered Email Address' ,
                email: 'Email address is not valid',
                remote: 'The Email Address is not registered with us'
            },
        },
        submitHandler: function() {
            $("#forgotBtn").attr("disabled", "disabled");
            return true;
        }
    });
});