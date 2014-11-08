var createAlert = function(siaranId) {
	$.post("?", {request: "deskripsi",id: siaranId}, function(data) {
		createText(data);
	});
};

var initiateCheck = function(element) {
	$.post("?", {request: "status", id: element.attr("id")}, function(data) {
		if(data == 1) {
			element.prop("checked", true);
		}
	});
};

var sendChangeRequest = function(element) {
	var target;
	if(element.prop("checked")) {
		target = 0;
	} else {
		target = 1;
	}

	var ajax = $.post("?", {request: "change", checked: target, id: element.attr("id")}, function(data) {
		if(target == 1) {
			element.prop('checked', true);
		} else {
			element.prop('checked', false);
		}
	}).fail(function() {
		alert("connection error, try again later.");
	});
};

var clearJam = function(num) {
	$("#jam" + num).remove();
};

$(document).ready(function() {
	$('input[type="checkbox"]').each(function(index) {
		initiateCheck($(this));
	});

	$('input[type="checkbox"]').click(function(event) {
		event.preventDefault();
    	event.stopPropagation();
    	var element = $(this);
    	setTimeout(function() {
    		sendChangeRequest(element);
    	}, 500);
	});

	setInterval(function() {
		$.post("?", {request: "jam"}, function(data) {
			for(var i=2; i<data ; i++) {
				clearJam(i);
			}
		});
	}, 60*1000);
});