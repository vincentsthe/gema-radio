createAlert = function(message) {
	var overlay = document.createElement("div");
	overlay.setAttribute("id", "overlay");
	document.body.appendChild(overlay);

	var notifBox = document.createElement("div");
	notifBox.setAttribute("id", "notif-box");
	overlay.appendChild(notifBox);

	var notifContent = document.createElement("div");
	notifContent.setAttribute("id", "notif-content");
	notifBox.appendChild(notifContent);

	var button = document.createElement("button");
	button.setAttribute("class", "btn btn-warning");
	button.setAttribute("id", "notif-button");
	notifBox.appendChild(button);

	$("#notif-button").html("OK");

	$("#notif-content").html(message);

	$("#overlay").click(function() {
		$("#overlay").remove();
	});
};
createText = function(message) {
	var overlay = document.createElement("div");
	overlay.setAttribute("id", "overlay");
	document.body.appendChild(overlay);

	var notifBox = document.createElement("div");
	notifBox.setAttribute("id", "notif-box");
	overlay.appendChild(notifBox);

	var notifContent = document.createElement("div");
	notifContent.setAttribute("id", "notif-text");
	notifBox.appendChild(notifContent);

	var button = document.createElement("button");
	button.setAttribute("class", "btn btn-warning");
	button.setAttribute("id", "notif-button");
	notifBox.appendChild(button);

	$("#notif-button").html("OK");

	$("#notif-text").html(message);

	$("#overlay").click(function() {
		$("#overlay").remove();
	});
};
createSource = function(cmessage, pasmessage) {
	var overlay = document.createElement("div");
	overlay.setAttribute("id", "overlay");
	document.body.appendChild(overlay);

	var notifBox = document.createElement("div");
	notifBox.setAttribute("id", "notif-box");
	overlay.appendChild(notifBox);

	var notifContent = document.createElement("div");
	notifContent.setAttribute("id", "notif-text");
	notifBox.appendChild(notifContent);

	var cppTitle = document.createElement("div");
	cppTitle.style.color = "black";
	cppTitle.style.fontSize = "2em";
	cppTitle.innerHTML = "C++";
	notifContent.appendChild(cppTitle);

	$("#notif-text").html($("#notif-text").html() + cmessage);

	var div = document.createElement("div");
	div.innerHTML = "Save this code as .cpp file and submit the file.<br><br><br><br>";
	div.style.color = "black";
	notifContent.appendChild(div);

	var pascalTitle = document.createElement("div");
	pascalTitle.style.color = "black";
	pascalTitle.style.fontSize = "2em";
	pascalTitle.innerHTML = "Pascal";
	notifContent.appendChild(pascalTitle);

	$("#notif-text").html($("#notif-text").html() + pasmessage);

	var div = document.createElement("div");
	div.innerHTML = "Save this code as .pas file and submit the file.";
	div.style.color = "black";
	notifContent.appendChild(div);

	var button = document.createElement("button");
	button.setAttribute("class", "btn btn-warning");
	button.setAttribute("id", "notif-button");
	notifBox.appendChild(button);

	$("#notif-button").html("OK");

	$("#pascal-text").html(pasmessage);

	$("#notif-button").click(function() {
		$("#overlay").remove();
	});
};