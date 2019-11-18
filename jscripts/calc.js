function change_calc(t,b) {
	var f = t.form, j = -1;var p1 = '';
	var exp_v = f.exp.options[f.exp.selectedIndex].text;
	var imp_v = f.imp.options[f.imp.selectedIndex].text;
	var dest_v = f.dest.options[f.dest.selectedIndex].text;
	if (t.name=='exp') { var p1 = 'exp', p2 = 'imp', p3 = 'dest'; }
	if (t.name=='imp') { var p1 = 'imp', p2 = 'exp', p3 = 'dest'; }
	if (t.name=='dest') { var p1 = 'dest', p2 = 'exp', p3 = 'imp'; }

	if (p1) {
	var a = new Array(), s = '';
	for(i=0;i<exp_p.length;i++)
		if (eval(p1+'_v').toUpperCase()==eval(p1+'_p')[i].toUpperCase()) a.push(eval(p2+'_p')[i]);
	a.sort();var i = 1;var f1 = a[0];
	while (i<a.length) if (a[i-1].toUpperCase()==a[i].toUpperCase()) a.splice(i,1); else i++;
	for(i=0;i<a.length;i++) if (a[i].toUpperCase()!=eval(p2+'_v').toUpperCase()) s += '<option>'+a[i]+'</option>';
		else { s += '<option selected>'+a[i]+'</option>';f1 = a[i]; }
	document.getElementById(p2+'_span').innerHTML = '<select size=1 style="width:147px;" name='+p2+' onChange="change_calc(this,'+b+');">'+s+'</select>';

	var a = new Array(), s = '';
	for(i=0;i<exp_p.length;i++) if (eval(p1+'_v').toUpperCase()==eval(p1+'_p')[i].toUpperCase() && f1.toUpperCase()==eval(p2+'_p')[i].toUpperCase()) a.push(eval(p3+'_p')[i]);
	a.sort();var i = 1;var f2 = a[0];
	while (i<a.length) if (a[i-1].toUpperCase()==a[i].toUpperCase()) a.splice(i,1); else i++;
	for(i=0;i<a.length;i++) if (a[i].toUpperCase()!=eval(p3+'_v').toUpperCase()) s += '<option>'+a[i]+'</option>';
		else { s += '<option selected>'+a[i]+'</option>';f2 = a[i]; }
	document.getElementById(p3+'_span').innerHTML = '<select size=1 style="width:147px;" name='+p3+' onChange="change_calc(this,'+b+');">'+s+'</select>';
	if (t==f.exp) { imp_v = f1;dest_v = f2; }
	if (t==f.imp) { exp_v = f1;dest_v = f2; }
	if (t==f.dest) { exp_v = f1;imp_v = f2; }
	}

	for(i=0;i<exp_p.length;i++)
		if (exp_p[i]==exp_v && imp_p[i]==imp_v && dest_p[i]==dest_v) j = i;
        if (j==-1) {
                document.getElementById('p1').innerHTML = '0';
                document.getElementById('pp1').innerHTML = '';
                document.getElementById('p2').innerHTML = '0';
                document.getElementById('pp2').innerHTML = '';
                document.getElementById('p3').innerHTML = '0';
                document.getElementById('pp3').innerHTML = '';
                document.getElementById('p4').innerHTML = '0';
                document.getElementById('pp4').innerHTML = '';
                document.getElementById('p5').innerHTML = '0';
                document.getElementById('pp5').innerHTML = '';
                if (b==1) document.getElementById('total').innerHTML = f.sum.value;
                        else document.getElementById('sum').innerHTML = f.total.value;
                alert('error');
                return;
        }
        document.getElementById('p1').innerHTML = s1[j];
        document.getElementById('pp1').innerHTML = d1[j];
        document.getElementById('p2').innerHTML = s2[j];
        document.getElementById('pp2').innerHTML = d2[j];
        document.getElementById('p3').innerHTML = s3[j];
        document.getElementById('pp3').innerHTML = d3[j];
        document.getElementById('p4').innerHTML = s4[j];
        document.getElementById('pp4').innerHTML = d4[j];
        document.getElementById('p5').innerHTML = s5[j];
        document.getElementById('pp5').innerHTML = d5[j];
        if (b==1) document.getElementById('total').innerHTML = parseInt(f.sum.value) + parseInt(s1[j]) + parseInt(s2[j]) + parseInt(s3[j]) + parseInt(s4[j]) + parseInt(s5[j]);
                else document.getElementById('sum').innerHTML = parseInt(f.total.value) - parseInt(s1[j]) - parseInt(s2[j]) - parseInt(s3[j]) - parseInt(s4[j]) - parseInt(s5[j]);
        return;
}

