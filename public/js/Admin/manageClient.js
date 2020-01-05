$(document).ready(function () {

    populateGrid();
    
    $("#addClientForm").validate({
        wrapper: "label",
        focusInvalid: true,
        rules: {
            name: {
                required: true,
            },
            phone_number: {
                required: true,
            },
            email: {
                required: true,
                email: true,
                remote: {
                url: "/admin/isUniqueClientEmail",
                type: "post",
                data: {'email': function () {
                        return ($('#email').val());
                    }},
                async: true
            }
            },
            password: {
                required: true,
            },
            confirmPassword: {
                required: true,
                equalTo: "#password",
            }
        },
        messages: {
            name: {
                required: 'This is required',
            },
            phone_number: {
                required: 'This is required',
            },
            email: {
                required: 'This is required',
                email: 'Please enter valid Email Address',
                remote: 'Email already exists'
            },
            password: {
                required: 'This is required',
            },
            confirmPassword: {
                required: 'This is required',
                equalTo: "These passwords don't match. Try again?",
            }
        },
        submitHandler: function () {
            valid = true;
            return valid;
        }
    });    
    
    
});

function populateGrid(role) {
    $("#clientTable").DataTable({
        'responsive': true,
        "aaSorting": [[0, "desc"]],
        "aoColumns": [
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false}
        ],
        'bRetrieve': true,
        'bPaginate': true,
        'bDestroy': true,
        'bProcessing': true,
        'bServerSide': true,
        'sAjaxSource': '/admin/getClientGrid',
    });
}