function openPopup(obj, boxWidth, boxHeight){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=" + boxWidth + ",height=" + boxHeight + ",left=" + ((sw - boxWidth) / 2) + ",top=" + ((sh - boxHeight) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=yes,scrollbars=yes,resizable=no";
		thisWin = window.open(obj,'AddMedia',winOpt);
	}		
function editComments(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=300,height=600,left=" + ((sw - 300) / 2) + ",top=" + ((sh - 600) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Slimzora',winOpt);
	}
function slimWin(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=300,height=400,left=" + ((sw - 300) / 2) + ",top=" + ((sh - 400) / 2) + ",menubar=no,toolbar=yes,location=no,directories=no,status=yes,scrollbars=yes,resizable=yes";
		thisWin = window.open(obj.href,'Slimzora',winOpt);
	}
function uploadPopup(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=350,height=400,left=" + ((sw - 350) / 2) + ",top=" + ((sh - 400) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Upload',winOpt);
	}	
	
function artistPopup(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=225,height=400,left=" + ((sw - 225) / 2) + ",top=" + ((sh - 400) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Artist',winOpt);
	}	

function albumEditWin(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=320,height=650,left=" + ((sw - 300) / 2) + ",top=" + ((sh - 650) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Album',winOpt);
	}	
function SubmitForm(form, a, replace) {  
		if (replace) { 
			document.forms[form].action = a; 
		} else {
			document.forms[form].action = document.forms[form].action + a;  
		}
		document.forms[form].submit(); 
	}

function CheckBoxes(form, v){
		for (var i=0; i < document.forms[form].elements.length; i++) {
			var j = document.forms[form].elements[i];
			if (j.type == "checkbox") { j.checked = v; }
		}
	}

function AreYouSure(){
		if (confirm('Are you TOTALLY sure???')){
			return true;	
		} else {
			return false;
		}
	}
	
function newWin(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=360,height=675,left=" + ((sw - 360) / 2) + ",top=" + ((sh - 675) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Info',winOpt);
	}
	
function newWindow(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=320,height=520,left=" + ((sw - 320) / 2) + ",top=" + ((sh - 520) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'newWin',winOpt);
	}
	
function discussionWindow(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=500,height=500,left=" + ((sw - 500) / 2) + ",top=" + ((sh - 500) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Discussion',winOpt);
	}
	
function ratingWindow(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=320,height=125,left=" + ((sw - 320) / 2) + ",top=" + ((sh - 125) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Rating',winOpt);
	}

function lyricsWindow(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=320,height=320,left=" + ((sw - 320) / 2) + ",top=" + ((sh - 320) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no";
		thisWin = window.open(obj.href,'Lyrics',winOpt);
	}
	
function helpWin(obj){
		var sw = screen.width;
		var sh = screen.height;
		var winOpt = "width=500,height=500,left=" + ((sw - 500) / 2) + ",top=" + ((sh - 500) / 2) + ",menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes";
		thisWin = window.open(obj.href,'Help ',winOpt);
	}
	
function showHideCon(id,ln) {
		var bSB = false;
		var oContent = document.getElementById(id+"Content");
		var oDisplay = document.getElementById(name+"Display");
		
		if (!oContent) return;
		if (ln != "yes" && !oDisplay) return;
		
		bOn = (oContent.style.display.toLowerCase() == "none");
		
		if (bOn == false) {
		oContent.style.display = "none";
			document.showhideForm.songDisplay.value = "<?php echo $word_show_tracks; ?>";
		} else {
		oContent.style.display = "";
			document.showhideForm.songDisplay.value = "<?php echo $word_hide_tracks; ?>";
		}
	}