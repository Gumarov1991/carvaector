
$(document).ready(function() {	
	$('input[name="login"]').bind('textchange', function() {
		if (!isValidEmailAddress($('input[name="login"]').val())) {
			var validstr = $("#validstr");
			var marginnull = $("#input-login")
			validstr.html('E-mail may be not valid');
			validstr.css({
				"color" : "red",
				"font-size" : "14px",
				"display" : "inline-block",
				"padding" : "15px",
				"margin-top" : "-15px"
			})
			marginnull.css({
				"margin-bottom" : "0px !important"
			})
		} else {
			validstr.html('');
			marginnull.css({
				"margin-bottom" : "15px"
			}) 
		}
	});	
});

function check_in(t) {
	if (!t.login.value || !t.pass.value) {
		alert ('E-mail or/and Password is empty');
	return false;
	}
	// if (!isValidEmailAddress(t.login.value)) {
	// 	alert('E-mail: "' + t.login.value + '" is not valid.');
	// 	return false;
	// }
	return true;	
}

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}

(function(a){a.event.special.textchange={setup:function(){a(this).data("lastValue",this.contentEditable==="true"?a(this).html():a(this).val());a(this).bind("keyup.textchange",a.event.special.textchange.handler);a(this).bind("cut.textchange paste.textchange input.textchange",a.event.special.textchange.delayedHandler)},teardown:function(){a(this).unbind(".textchange")},handler:function(){a.event.special.textchange.triggerIfChanged(a(this))},delayedHandler:function(){var c=a(this);setTimeout(function(){a.event.special.textchange.triggerIfChanged(c)},
25)},triggerIfChanged:function(a){var b=a[0].contentEditable==="true"?a.html():a.val();b!==a.data("lastValue")&&(a.trigger("textchange",[a.data("lastValue")]),a.data("lastValue",b))}};a.event.special.hastext={setup:function(){a(this).bind("textchange",a.event.special.hastext.handler)},teardown:function(){a(this).unbind("textchange",a.event.special.hastext.handler)},handler:function(c,b){b===""&&b!==a(this).val()&&a(this).trigger("hastext")}};a.event.special.notext={setup:function(){a(this).bind("textchange",
a.event.special.notext.handler)},teardown:function(){a(this).unbind("textchange",a.event.special.notext.handler)},handler:function(c,b){a(this).val()===""&&a(this).val()!==b&&a(this).trigger("notext")}}})(jQuery);

