var tab = 0;
var activeTab = 0;
var currentTab;
var tanggalSiaran = [];
var jamSiaran = [];

var addInputField = function(siaran, tanggal, jam) {
	var tanggalInput = document.createElement("input");
	tanggalInput.setAttribute("type", "hidden");
	tanggalInput.setAttribute("id", "tanggal" + siaran);
	tanggalInput.setAttribute("name", "Siaran[" + siaran + "][tanggal]");
	document.getElementById("input").appendChild(tanggalInput);

	var jamInput = document.createElement("input");
	jamInput.setAttribute("type", "hidden");
	jamInput.setAttribute("id", "jam" + siaran);
	jamInput.setAttribute("name", "Siaran[" + siaran + "][jam]");
	document.getElementById("input").appendChild(jamInput);

	$("#tanggal" + siaran).val(tanggal);
	$("#jam" + siaran).val(jam);
}

var chooseTab = function(siaran) {

	if(siaran == 0) {
		activeTab = 0;

		$("#tanggalSiaran").prop("disabled", true);
		$("#jamSiaran").prop("disabled", true);

		$("#tanggalSiaran").val("");
		$("#jamSiaran").val("");
	} else {
		$("#tanggalSiaran").prop("disabled", false);
		$("#jamSiaran").prop("disabled", false);

		//save the currentTab first
		if((activeTab!=0) && (activeTab <= tab)) {
			tanggalSiaran[activeTab-1] = $("#tanggalSiaran").val();
			jamSiaran[activeTab-1] = $("#jamSiaran").val();
		}

		//change to the selected tab
		activeTab = siaran;

		for(var i=1 ; i<=tab ; i++) {
			$("#tab" + i).removeClass("active");
		}

		$("#tab" + siaran).addClass("active");

		$("#tanggalSiaran").val(tanggalSiaran[siaran-1]);
		$("#jamSiaran").val(jamSiaran[siaran-1]);
	}
};

var addTab = function(siaran) {
	var li = document.createElement("li");
	document.getElementById("tab").appendChild(li);
	li.setAttribute("id", "tab" + siaran);
	if(siaran == 1) {
		li.setAttribute("class", "active");
	}

	var a = document.createElement("a");
	li.appendChild(a);
	a.setAttribute("id", "siaran" + siaran);
	a.appendChild(document.createTextNode("Siaran " + siaran));

	var today = new Date();
	var year = today.getFullYear();
	var month = today.getMonth()+1;
	if(month < 10) {
		month = "0" + month;
	}
	var day = today.getDate();
	if(day < 10) {
		day = "0" + day;
	}
	var hour = today.getHours();
	if(hour < 10) {
		hour = "0" + hour;
	}
	var minute = today.getMinutes();
	if(minute < 10) {
		minute = "0" + minute;
	}

	tanggalSiaran.push(year + "-" + month + "-" + day);
	jamSiaran.push(hour + ":" + minute);

	var tmp = activeTab;

	$("#tab" + siaran).click(function() {
		chooseTab(siaran);
	});
};

var submitForm = function() {
	chooseTab(activeTab);

	for(var i=1 ; i<=tab ; i++) {
		addInputField(i, tanggalSiaran[i-1], jamSiaran[i-1]);
	}
	$("#form").submit();
}

var removeTab = function(siaran) {
	$("#tab" + siaran).unbind();
	$("#tab" + siaran).remove();

	tanggalSiaran.pop();
	jamSiaran.pop();

	if(activeTab == siaran) {
		chooseTab(siaran-1);
	}
};

$(document).ready(function() {

	$("#noOrder").prop("disabled", true);

	$("#tanggal").datetimepicker({
		timepicker:false,
		format:"Y-m-d",
	});

	$("#jumlahSiaran").spinner({
		min: 0,
		max: 20,
		stop: function(e, ui) {
			$(this).change();
		},
	});

	$("#jenisTransaksi").change(function() {
		if($("#jenisTransaksi").val() == "Iklan nasional") {
			$("#noOrder").prop("disabled", false);
		} else {
			$("#noOrder").prop("disabled", true);
		}
	});

	$("#tanggalSiaran").datetimepicker({
		timepicker:false,
		format:"Y-m-d",
	});

	$("#jamSiaran").datetimepicker({
		datepicker:false,
		format: "H:i",
	});

	$("#tanggalSiaran").prop("disabled", true);
	$("#jamSiaran").prop("disabled", true);

	//initialize siaran
	$.get("?request=siaran", function(data) {
		siaran = data;
		chooseTab(0);

		var i=0;
		for(var d in siaran) {
			addTab(i+1);
			tanggalSiaran[i] = siaran[d]['tanggal'];
			jamSiaran[i] = siaran[d]['jam'];
			i++;
		}
		console.log(jamSiaran);

		tab = i;
		$("#jumlahSiaran").val(i);

		if(tab > 0) {
			chooseTab(1);
		}
	});

	$("#jumlahSiaran").change(function() {
		currentTab = parseInt($("#jumlahSiaran").val());

		if(tab < currentTab) {
			addTab(currentTab);
			if(currentTab == 1) {
				chooseTab(1);
			}
		} else {
			removeTab(tab);
		}

		tab = currentTab;
	});

	$("#button").click(function() {
		submitForm();
	});
});