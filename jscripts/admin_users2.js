$(document).ready(function(){
	
	scroll_to_bottom(1);
	gLinePaid()

	$(".upLine").click(function() {
		var curA = $(this);
		var LineId = $(this.parentNode.parentNode).attr('id');
		var LineIdPrev = $(this.parentNode.parentNode).prev().attr('id');
		var SortId = $(this.parentNode.parentNode).attr('sort_id');
		var SortIdPrev = $(this.parentNode.parentNode).prev().attr('sort_id');
		if (SortIdPrev != 'undefined') {
			$(this.parentNode.parentNode).attr({'sort_id' : SortIdPrev});
			$(this.parentNode.parentNode).prev().attr({'sort_id' : SortId});
			$('#bal_table tr[id='+ LineIdPrev +']').insertAfter($(this.parentNode.parentNode));
			gLineSumm();
			gLinePaid();
			greyArr(curA);
			$.ajax({ 
				type:'POST', url:'./admin_aj.php?users', data: { act: 'mov', totalid: LineId, totalid2: LineIdPrev }, dataType: "json",
				beforeSend: function(){
					var lPos = $('#bal_table tr[id="' + LineId + '"]').position();
					$('#mcycle').css({'display': 'block', 'left': (lPos.left+80) + 'px', 'top': lPos.top + 'px'});					
				},
				success: function(data){
					if (data != 'ok') alert ('Сервер не прислал подтверждения о записи перемещения строк\nПожалуйста перезагрузите страницу!');
				},
				error: function(){alert("error: act=" + act + "\n" + "Ошибка выполнения ajax запроса");},
				complete: function(){
					$('#mcycle').css({"display":"none"});
				}
			});				
		}
		return false;		
	});

	$(".dnLine").click(function() {
		var curA = $(this);
		var LineId = $(this.parentNode.parentNode).attr('id');
		var LineIdNext = $(this.parentNode.parentNode).next().attr('id');
		var SortId = $(this.parentNode.parentNode).attr('sort_id');
		var SortIdNext = $(this.parentNode.parentNode).next().attr('sort_id');
		if (SortIdNext != 'undefined') {			
			$(this.parentNode.parentNode).attr({'sort_id' : SortIdNext});
			$(this.parentNode.parentNode).next().attr({'sort_id' : SortId});
			$('#bal_table tr[id='+ LineIdNext +']').insertBefore($(this.parentNode.parentNode));
			gLineSumm();
			gLinePaid();
			greyArr(curA);
			$.ajax({ 
				type:'POST', url:'./admin_aj.php?users', data: { act: 'mov', totalid: LineId, totalid2: LineIdNext }, dataType: "json",
				beforeSend: function(){
					var lPos = $('#bal_table tr[id="' + LineId + '"]').position();
					$('#mcycle').css({'display': 'block', 'left': (lPos.left+80) + 'px', 'top': lPos.top + 'px'});					
				},
				success: function(data){
					if (data != 'ok') alert ('Сервер не прислал подтверждения о записи перемещения строк\nПожалуйста перезагрузите страницу!');
				},
				error: function(){alert("error: act=" + act + "\n" + "Ошибка выполнения ajax запроса");},
				complete: function(){
					$('#mcycle').css({"display":"none"});
				}
			});							
		}
		return false;		
	});

	
});

function gLineSumm() {
	var gTotal= 0;	
	$('#bal_table tr[id] td[name="summ"]').each(function(index) {
		gTotal += $(this).text() * 1;
		$(this).next().text(gTotal);
		if (gTotal < 0) $(this).next().css({'color': 'red'}); else $(this).next().css({'color': 'black'});		
	});
};

function scroll_to_bottom(speed) {
	var height= $("body").height(); 
	$("html,body").animate({scrollTop:$(document).height()},speed);
	return false;
}

function gLinePaid() {
	var totalLines = $('#bal_table tr[id] td[name="summ"]').length;
	var start = 1;
	$('#bal_table tr[id] td[name="summ"]').each(function(index) {
		$(this.parentNode).attr({'count' : start});
		start++;
	});
	var flag = 0;	
	for(var i=totalLines;i>0;i--) {
		var curCell = $('#bal_table tr[count="' + i + '"] td[name="summ"]');
		var summ = curCell.text();
		curCell.css({'background-color': '#ffffff', 'border-bottom': '0px solid black'});
		curCell.prev().css({'background-color': '#ffffff', 'border-bottom': '0px solid black'});
		if (flag == 1) {
			curCell.prev().prev().css({'background-color': '#ffffff', 'border-bottom': '0px solid black'});
			if (summ < 0) {
				curCell.prev().css({'background-color': '#99FF66', 'border-bottom': '0px solid black'});
			} else {
				curCell.prev().css({'background-color': '#ffffff', 'border-bottom': '0px solid black'});
			}
			curCell.css({'background-color': '#99FF66', 'border-bottom': '0px solid black'});
			curCell.next().css({'background-color': '#FFFFFF', 'border-bottom': '0px solid black'});
		} else if (flag == 0 && summ > 0) {
			curCell.prev().prev().css({'background-color': '#ffffff', 'border-bottom': '2px solid black'});
			curCell.prev().css({'background-color': '#ffffff', 'border-bottom': '2px solid black'});
			curCell.css({'background-color': '#99FF66', 'border-bottom': '2px solid black'});
			curCell.next().css({'background-color': '#FFFF00', 'border-bottom': '2px solid black'});
			flag = 1;
		}
	}
};

function greyArr(curA) {
	$('.arrL').each(function(index) {
		$(this.parentNode).css({'background': '#ffffff'});
	});	
	$(curA).parent().css({'background': '#ccc'});
};