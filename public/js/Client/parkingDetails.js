$(document).ready(function () {
   
    $(document).on('click', '.parking_model', function () {
        $('#open_parking_model').find('label[class="error"]').remove();
        var self = $(this);
        var parkingType = self.data('parking-type');
        $("#parking_type").val(parkingType);
        var slotId = self.data('slot-id');
        $("#slot_id").val(slotId);
        if(parkingType == "free") {
            var carData = self.data('car-data');
            var carDetails = carData.split("-");
            $("#state_name").val(carDetails[0]).attr('readonly', true);
            $("#state_code").val(carDetails[1]).attr('readonly', true);
            $("#car_series").val(carDetails[2]).attr('readonly', true);
            $("#car_number").val(carDetails[3]).attr('readonly', true);
            $(".booking_form_submit").val("Free Slot");
        }
        else{
            $("#state_name").val('MH').attr('readonly', false);
            $("#state_code").val('12').attr('readonly', false);
            $("#car_series").val('').attr('readonly', false);
            $("#car_number").val('').attr('readonly', false);
            $(".booking_form_submit").val("Submit");
        }
        var search_modal = $("#open_parking_model").modal();
        search_modal.show();
    });

    $("#book_parking_form").validate({
        wrapper: "label",
        focusInvalid: true,
        rules: {
            state_name: {
                required: true,
            },
            state_code: {
                required: true,
            },
            car_series: {
                required: true,
            },
            car_number: {
                required: true,
            },
            parking_cost: {
                required: true,
            }
        },
        messages: {
            state_name: {
                required: 'This is required',
            },
            state_code: {
                required: 'This is required',
            },
            car_series: {
                required: 'This is required',
            },
            car_number: {
                required: 'This is required',
            },
            parking_cost: {
                required: 'This is required',
            }
        },
        submitHandler: function () {
            valid = false;
            var partkingType = $("#parking_type").val();
            var partkingId = $("#parking_id").val();
            var slotId = $("#slot_id").val();
            var patkingCost = $("#parking_cost").val();
            if(partkingType == "free" && patkingCost == "") {
                $.ajax({
                    url: '/client/calculatePrice',
                    type: 'POST',
                    data: {'partkingId': partkingId,
                           'slot_id' : slotId
                          },
                    success: function (response) {
                        var res = $.parseJSON(response);
                        if (res.flag == "true") {
                            valid = true;
                            $("#price_details").show();
                            $("#parking_cost").val(res.cost);
                        } else {
                            $("#price_details").hide();
                            $("#parking_cost").val('');
                            $("#open_parking_model").modal('hide');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        return false;
                    }
                });
            }
            else{
                valid = true;
            }
            console.log(partkingType,"=====",patkingCost);
            return valid;
        }
    });
    
    $(".clear-button").click(function (e) {
        $("#open_parking_model").modal('hide');
    });    
});