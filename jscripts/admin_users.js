	var gLineId;
	var gColName;
	var gCurCell;
	var gCurText;
	var bal = $('#bal').text();
	var gFlag;

$(document).ready(function(){
	
	gLineMonthColor();
	scroll_to_bottom(1);
	
	$("#gbut").click(function() {
		gLineMonthColor()		
		return false;		
	});
	
	$("#addLine").click(function() {
		gAjaxAdd()		
		return false;		
	});

	$(document).on("click", ".delLine", function(){
		var LineId = $(this.parentNode.parentNode).attr('id');
		gAjaxDel(LineId)		
		return false;		
	});

	$(document).on("dblclick", "#bal_table td[name]", function(){
		gCurCell = this;
		gLineId = this.parentNode.id;
		gColName = $(this).attr('name');
		gCurText = $(this).text();
		gPutEditor();
		return false;
	});
	
	$(window).on( 'resize scroll', rePosition );
	
});


function rePosition() {
		var lPos = $(gCurCell).position();
		if (gColName == "summ") {
			$('#editor').css({'text-align': 'right', 'left': (lPos.left) + 'px'});
		} else {
			$('#editor').css({'text-align': 'left', 'left': (lPos.left + 2) + 'px'});
		}
		$('#editor').css({
			'top': (lPos.top) + 'px',
			'width': $(gCurCell).width() + 18,
			'height': $(gCurCell).height() + 6
		});
		$('#mcycle').css({'left': (lPos.left+5) + 'px', 'top': (lPos.top+4) + 'px'});				

}

function gPutEditor() {
	$(window).bind('mousewheel', function(e) {e.preventDefault()});
	var lPos = $(gCurCell).position();
	if (gColName == "summ") {
		$('#editor').css({'text-align': 'right', 'left': (lPos.left) + 'px'});
	} else {
		$('#editor').css({'text-align': 'left', 'left': (lPos.left + 2) + 'px'});
	}
	$('#editor').css({
		'top': (lPos.top) + 'px',
		'width': $(gCurCell).width() + 18,
		'height': $(gCurCell).height() + 6,
		'background-color': '#ddf'
	}).val($(gCurCell).text()).show().select();
	document.onkeydown = function(e){ 
		if (e == null) {
			keycode = event.keyCode; 
		} else {
			keycode = e.which; 
		} 
		if (keycode == 27){
			$('#editor').hide();
			$(window).unbind('mousewheel');
		} 
		if (keycode == 13) {
			gHandleData()
		}
	};
	
};

function gHandleData() {
	if ($('#editor').val() != $(gCurCell).text()) {
		gCurText = $('#editor').val();
		if (gColName == "summ") {
			var gSumm1 = gCurText.replace(/\s/g, "");
			var gSumm = String(gSumm1 * 1);
			if (!(/^-?[0-9]+$/.test(gSumm))) {
				alert('Сумма должна быть целым числом!'+'\n'+'Исправьте пожалуйста!');
				$('#editor').select();
			} else {
				if (gSumm < 0) $(gCurCell).css({'color': 'red'}); else $(gCurCell).css({'color': 'black'});
				gAjaxEdit( gLineId, 'summ', gSumm);
			}
		} else if (gColName == "date") {
			var re = /^[0-9]{4}-([0][1-9]|[1][0-2])-([0][1-9]|1[0-9]|2[0-9]|3[0-1])\s([0-1][0-9]|[2][0-3])(:([0-5][0-9])){1,2}$/i;
			if (!(re.test(gCurText))) {
				alert('Дата должна быть в формате ГГГГ-ММ-ДД ЧЧ:ММ:СС !'+'\n'+'Исправьте пожалуйста!');
				$('#editor').select();
			} else {
				gAjaxEdit( gLineId, 'date', gCurText);
			}
		} else if (gColName == "oper") {
			gAjaxEdit( gLineId, 'oper', gCurText);
		} else alert ('Недопустимая переменная gColName');
	} else {
		$('#editor').hide();
		$(window).unbind('mousewheel');
	}
};
	
	
function gAjaxEdit(id, col, dat) {
	$.ajax({ 
		type:'POST', url:'./admin_aj.php?users', data: { act: 'edit', totalid: id, col: col, dat: dat, bal: bal }, dataType: "json",
		beforeSend: function(){
			$('#editor').hide();
			$(window).unbind('mousewheel');
			var gTemp = $(gCurCell).text();
			$(gCurCell).text(dat);
			var lPos = $(gCurCell).position();
			$('#mcycle').css({'display': 'block', 'left': lPos.left + 'px', 'top': lPos.top + 'px', 'width': $(gCurCell).width()+18, 'height': $(gCurCell).height()+6});					
		},
		success: function(data){
			if (dat == data.ts || dat == data.operation || dat == data.summ) {
				if (col == "summ") {
					gLineSumm1(data.total);
				} else if (col == "date") {
					$('#bal_table tr[id]').each(function(index) {
						if (this.id != id) {
							var ts_date = data.ts;			
							var curdate = $('> td[name="date"]', this).text();
							gFlag = 0;
							if (curdate >= ts_date) {
								$('#bal_table tr[id='+ id +']').insertBefore($(this));
								gFlag = 1;
								return false;
							} 
						}
					});
					if ((gFlag == 0) && ($('#bal_table tr[id]:last').attr('id') != id)) {
						$('#bal_table tr[id='+ id +']').insertAfter($('#bal_table tr[id]:last'));
					}
					gLineSumm2();
				}
			} else {
				$(gCurCell).text(gTemp);
				alert ('Ошибка записи на сервере. Отправлено:' + dat + '\n' + 'Полученные данные НЕ совпадают с отправленными' + '\n' + 'act: ' + act);
			}
		},
		error: function(){alert("error: act=" + act + "\n" + "Ошибка выполнения ajax запроса");},
		complete: function(){
			$('#mcycle').css({"display":"none"});
		}
	});
};

function gAjaxAdd() {
	$.ajax({ 
		type:'POST', url:'./admin_aj.php?users', data: { act: 'add', bal: bal }, dataType: "json",
		beforeSend: function(){
			$('#editor').hide();			
			$(window).unbind('mousewheel');
			var lPos = $('#bal_table tr:last').position();
			$('#mcycle').css({'display': 'block', 'left': lPos.left + 'px', 'top': lPos.top + 'px', 'width': $(gCurCell).width()+18, 'height': $(gCurCell).height()+6});					
		},
		success: function(data){
			var id = data.total;
			var gNewLine = '';
			gNewLine += '<tr id="' + data.total + '">'
			gNewLine += '<td class=form-ta width=10 nowrap><a class="delLine" href="#"><img src="./pics/del.gif" border=0 width=9 height=10 alt="Удалить транзакцию" title="Удалить транзакцию"></a></td>'
			gNewLine += '<td class=form-ta name="date" width=150 nowrap>' + data.ts + '</td></td>'
			gNewLine += '<td class=form-ta name="oper" style="white-space: pre-wrap;empty-cells:show"></td>'
			gNewLine += '<td class=form-ta name="summ" width=100 nowrap align=right>' + data.summ + '</td>'
			gNewLine += '<td class=form-ta abbr="subtotal" width=100 nowrap align=right></td>'
			gNewLine += '</tr>'
			$('#bal_table tr:last').before(gNewLine);
			$('#bal_table tr[id]').each(function(index) {
				if (this.id != id) {
					var ts_date = data.ts;			
					var curdate = $('> td[name="date"]', this).text();
					gFlag = 0;
					if (curdate >= ts_date) {
						$('#bal_table tr[id='+ id +']').insertBefore($(this));
						gFlag = 1;
						return false;
					} 
				}

			});
			
			if ((gFlag == 0) && ($('#bal_table tr[id]:last').attr('id') != id)) {
				$('#bal_table tr[id='+ id +']').insertAfter($('#bal_table tr[id]:last'));
			}
			gLineSumm2();
		},
		error: function(){alert("error: act=" + act + "\n" + "Ошибка выполнения ajax запроса");},
		complete: function(){
			$('#mcycle').css({"display":"none"});
		}
	});
};

function gAjaxDel(LineId) {
	var tempSumm = $('#bal_table tr[id="' + LineId + '"] td[name="summ"]').text();
	if (!confirm ('БЕЗВОЗВРАТНОЕ УДАЛЕНИЕ!\n\nУдалить строку с суммой: ' + tempSumm + ' ?')) {
		return false;
	}
	$.ajax({ 
		type:'POST', url:'./admin_aj.php?users', data: { act: 'del', totalid: LineId, bal: bal }, dataType: "json",
		beforeSend: function(){
			$('#editor').hide();			
			$(window).unbind('mousewheel');
			var lPos = $('#bal_table tr[id="' + LineId + '"]').position();
			$('#mcycle').css({'display': 'block', 'left': lPos.left + 'px', 'top': lPos.top + 'px', 'width': $(gCurCell).width()+18, 'height': $(gCurCell).height()+6});					
		},
		success: function(data){
			$('#bal_table tr[id="' + LineId + '"]').remove();
			gLineSumm1(data.total);
		},
		error: function(){alert("error: act=" + act + "\n" + "Ошибка выполнения ajax запроса");},
		complete: function(){
			$('#mcycle').css({"display":"none"});
		}
	});	
};

function gLineSumm1(serTot) {
	if (serTot == 'empty') {
		$('#bal_table tr:last  td[abbr="total"]').html('<b>0</b>');	
		return;
	}
	var gTotal= 0;	
	$('#bal_table tr[id] td[name="summ"]').each(function(index) {
		gTotal += $(this).text() * 1;
		$(this).next().text(gTotal);
		if (gTotal < 0) $(this).next().css({'color': 'red'}); else $(this).next().css({'color': 'black'});		
	});
	$('#bal_table tr:last  td[abbr="total"]').html('<b>' + gTotal + '</b>');
	if (gTotal < 0) {
		$('#bal_table tr:last  td[abbr="total"]').css({'color': 'red'}); 
	} else {
		$('#bal_table tr:last  td[abbr="total"]').css({'color': 'black'});
	}
	if (serTot != gTotal) {
		alert ('Сервер прислал итог: ' + serTot + '\n' + 'Местный рассчет итога: ' + gTotal + '\n' + 'Ошибка! Обновите страницу!');
	}
	gLineMonthColor();
};

function gLineSumm2() {
	var gTotal= 0;	
	$('#bal_table tr[id] td[name="summ"]').each(function(index) {
		gTotal += $(this).text() * 1;
		$(this).next().text(gTotal);
		if (gTotal < 0) $(this).next().css({'color': 'red'}); else $(this).next().css({'color': 'black'});		
	});
	gLineMonthColor();
};

function gLineMonthColor() {
	var gMonthCount = 1;	
	var gYear;			
	var gMonth;							
	$('#bal_table tr[id] td[name="date"]').each(function(index) {
		if (index == 0) {
			gYear = $(this).text().substr(3, 1);			
			gMonth = $(this).text().substr(5, 2);						
		}
		if ((gMonth != $(this).text().substr(5, 2)) || (gYear != $(this).text().substr(3, 1))) {
			$(this).prev().css({'border-top': '1px solid black'});
			$(this).css({'border-top': '1px solid black'});
			$(this).next().css({'border-top': '1px solid black'});
			$(this).next().next().css({'border-top': '1px solid black'});
			$(this).next().next().next().css({'border-top': '1px solid black'});
			gMonthCount += 1;
		} else {
			$(this).prev().css({'border-top': '0px solid black'});
			$(this).css({'border-top': '0px solid black'});
			$(this).next().css({'border-top': '0px solid black'});
			$(this).next().next().css({'border-top': '0px solid black'});
			$(this).next().next().next().css({'border-top': '0px solid black'});			
		}
		if (gMonthCount % 2 == 0) $(this).css({'background-color': '#DDD'}); else $(this).css({'background-color': '#EEE'});		
		gYear = $(this).text().substr(3, 1);			
		gMonth = $(this).text().substr(5, 2);						
	});
};

function scroll_to_bottom(speed) {
	$("html,body").animate({scrollTop:$(document).height()},speed);
	return false;
}

function getElPos(elemId) {
	var elem = document.getElementById(elemId);
	var w = elem.offsetWidth;var h = elem.offsetHeight;var l = 0;var t = 0;
	while (elem) { l += elem.offsetLeft;t += elem.offsetTop;elem = elem.offsetParent; }
	return t;
}
