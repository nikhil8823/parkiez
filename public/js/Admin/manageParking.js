$(document).ready(function () {
    populateGrid();
    
    $("#addParkingForm").validate({
        wrapper: "label",
        focusInvalid: true,
        rules: {
            title: {
                required: true,
            },
            client_id: {
                checkClient: 'Select Owner',
            },
            description: {
                required: true,
            },
            slots: {
                required: true
            },
            cost: {
                required: true
            }
        },
        messages: {
            title: {
                required: 'This is required',
            },
            description: {
                required: 'This is required',
            },
            slots: {
                required: 'This is required',
            },
            cost: {
                required: 'This is required'
            }
        },
        submitHandler: function () {
            valid = true;
            return valid;
        }
    });
    
    $.validator.addMethod("checkClient", function (value) {
        return (value != 'Select Owner');
    }, "Please select owner");    
});

function populateGrid(role) {
    $("#parkingTable").DataTable({
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
        'sAjaxSource': '/admin/getParkingGrid',
    });
}