var divSelectModels;

function $() {
        var elements = new Array();
        for (var i = 0; i < arguments.length; i++) {
                var element = arguments[i];
                if (typeof element == "string")
                        element = document.getElementById(element);
                if (arguments.length == 1)
                        return element;
                elements.push(element);
        }
        return elements;
}

function findPos(obj) {
        var curleft = curtop = 0;
        if (obj.offsetParent) {
                curleft = obj.offsetLeft
                curtop = obj.offsetTop
                while (obj = obj.offsetParent) {
                        curleft += obj.offsetLeft
                        curtop += obj.offsetTop
                }
        }
        return [curleft,curtop];
}

function PopupDiv(strURL, x, y, w, h) {
        var divPopup = document.createElement("DIV");
        divPopup.style.position = "absolute";
        divPopup.style.border = "2px solid #000000"
        divPopup.style.top = y + "px";
        divPopup.style.left = x + "px";

        var iframe = document.createElement("IFRAME");
        iframe.src = strURL;
        iframe.width = w;
        iframe.height = h;
        iframe.frameborder = 0;

        divPopup.appendChild(iframe);
        body = document.getElementsByTagName("body")[0];
        body.appendChild(divPopup);
        return divPopup;
}

function selectmodels(blnStock) {
        var MyXPos, MyYPos, WinOpts;
        var MyHeight = 450;
        var MyWidth = 700;
        var objMake

        MyXPos =  0;
        MyYPos = 0;

        objMake = document.getElementsByName("make")[0];
        if (!objMake.value) return;

        url = "./scripts/selectmod.php?";
        if ( blnStock ) url = url + "stock=y&";
        if ($("atnd")) if ($("atnd").checked) url = url + "atnd=" + $("atnd").value + "&";
        url = url + "make=" + objMake.value

        objAuction = document.getElementsByName("a");
        for ( var i = 0; i < objAuction.length; i++ ){
          var elm = objAuction[i];
                if ( elm.checked == true ) {
                        url = url + "&a=" + elm.value
                }
        }

        if ( ! divSelectModels ) {
                var position = findPos(document.getElementById("mod"));
                divSelectModels = PopupDiv(url, 10, position[1]-5, MyWidth, MyHeight);
        }
}

function clearModels() {
        document.frmSearch.mod.value = "";
}

function closeDivSelectModels() {
        setTimeout("closeDivSelectModelsNow()", 10);
}

function closeDivSelectModelsNow() {
        if ( divSelectModels ) {
                divSelectModels.style.display = "none";
                var theParent = divSelectModels.parentNode;
                theParent.removeChild(divSelectModels);
                divSelectModels = null;
        }
}

function ToggleCheckBoxByValue(checkBoxes, varValue, blnChecked) {
	if ( checkBoxes.length != undefined ) {
		for (var count = 0; count < checkBoxes.length; count++) {
			if ( checkBoxes[count].value == varValue ) {
				checkBoxes[count].checked = blnChecked;
			}
		}
	} else {
		if ( checkBoxes.value == varValue ) {
			checkBoxes.checked = blnChecked;
		}
	}
}
