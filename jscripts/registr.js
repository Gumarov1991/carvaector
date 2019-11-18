$(document).ready(function () {
	$('input[name="r03"]').on('textchange', function () {
		if (!isValidEmailAddress($('input[name="r03"]').val())) {
			$("#validstr").html('This e-mail may be not valid !');
		} else {
			$("#validstr").html('');
		}
	});
});

function check_reg(t, e1, e2) {
	if (t.r01.value == 0 || !t.r02.value || !t.r03.value || !t.r04.value) {
		alert(e1);
		return false;
	}
	if (!isValidEmailAddress(t.r03.value)) {
		alert('E-mail: "' + t.r03.value + '" is not valid.');
		return false;
	}
	var p = t.r04.value;
	if (p.length < 6 || p.length > 20) {
		alert(e2);
		return false;
	}
	var i;
	for (i = 0; i < p.length; i++)
		if (!(('0' <= p[i] && p[i] <= '9') || ('a' <= p[i] && p[i] <= 'z') || ('A' <= p[i] && p[i] <= 'Z'))) {
			alert('Password must contain only letters and numbers.');
			return false;
		}
	if (!t.chb_term_agree.checked) {
		popupToggle_term(true);
		return false;
	}
	return true;
}

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);

}
