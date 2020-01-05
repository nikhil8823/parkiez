(function($){
$.fn.countdown = function(objOption){
  
  var settings = $.extend({
    // Below are the default settings.
    endDate:null,
    callback:null
  }, objOption );
  
var countDownDate = moment.tz(settings.endDate,appTimezone).format('x');
var currClass = $(this).attr('class');
// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = moment.tz(new Date(),appTimezone).format('x');
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var dayInHours = Math.floor(days * 24);
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var totalHours = Math.floor(dayInHours + hours);
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    $("."+currClass).html(totalHours + ":"
    + minutes + ":" + seconds + "");
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        //$("."+currClass).html("EXPIRED");
	var callback = settings.callback;
    if ($.isFunction(callback)) {
      var parameter = {'msg':'Expired', 'class':currClass};
      callback.call(this, parameter);
    }
    }
}, 1000);
  


}

})(jQuery);