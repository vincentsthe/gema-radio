var tab = 0;
var activeTab = 0;
var currentTab;
var tanggalSiaran = [];
var jamMulaiSiaran = [];
var jamSelesaiSiaran = [];

var addInputField = function(siaran, tanggal, jamMulai, jamSelesai) {
	var tanggalInput = document.createElement("input");
	tanggalInput.setAttribute("type", "hidden");
	tanggalInput.setAttribute("id", "tanggal" + siaran);
	tanggalInput.setAttribute("name", "Siaran[" + siaran + "][tanggal]");
	document.getElementById("input").appendChild(tanggalInput);

	var jamMulaiInput = document.createElement("input");
	jamMulaiInput.setAttribute("type", "hidden");
	jamMulaiInput.setAttribute("id", "jamMulai" + siaran);
	jamMulaiInput.setAttribute("name", "Siaran[" + siaran + "][jamMulai]");
	document.getElementById("input").appendChild(jamMulaiInput);

	var jamSelesaiInput = document.createElement("input");
	jamSelesaiInput.setAttribute("type", "hidden");
	jamSelesaiInput.setAttribute("id", "jamSelesai" + siaran);
	jamSelesaiInput.setAttribute("name", "Siaran[" + siaran + "][jamSelesai]");
	document.getElementById("input").appendChild(jamSelesaiInput);

	$("#tanggal" + siaran).val(tanggal);
	$("#jamMulai" + siaran).val(jamMulai + ":00");
	$("#jamSelesai" + siaran).val(jamSelesai + ":00");
}

var chooseTab = function(siaran) {
	if(siaran == 0) {
		activeTab = 0;

		$("#tanggalSiaran").prop("disabled", true);
		$("#jamMulaiSiaran").prop("disabled", true);
		$("#jamSelesaiSiaran").prop("disabled", true);

		$("#tanggalSiaran").val("");
		$("#jamMulaiSiaran").val("");
		$("#jamSelesaiSiaran").val("");
	} else {
		$("#tanggalSiaran").prop("disabled", false);
		$("#jamMulaiSiaran").prop("disabled", false);
		$("#jamSelesaiSiaran").prop("disabled", false);

		//save the currentTab first
		if((activeTab!=0) && (activeTab <= currentTab)) {
			tanggalSiaran[activeTab-1] = $("#tanggalSiaran").val();
			jamMulaiSiaran[activeTab-1] = $("#jamMulaiSiaran").val();
			jamSelesaiSiaran[activeTab-1] = $("#jamSelesaiSiaran").val();
		}

		//change to the selected tab
		activeTab = siaran;

		for(var i=1 ; i<=tab ; i++) {
			$("#tab" + i).removeClass("active");
		}

		$("#tab" + siaran).addClass("active");

		$("#tanggalSiaran").val(tanggalSiaran[siaran-1]);
		$("#jamMulaiSiaran").val(jamMulaiSiaran[siaran-1]);
		$("#jamSelesaiSiaran").val(jamSelesaiSiaran[siaran-1]);
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
	jamMulaiSiaran.push(hour + ":" + minute);
	jamSelesaiSiaran.push(hour + ":" + minute);

	if(siaran == 1) {
		chooseTab(siaran);
	}

	var tmp = activeTab;

	$("#tab" + siaran).click(function() {
		chooseTab(siaran);
	});
};

var submitForm = function() {
	chooseTab(activeTab);

	for(var i=1 ; i<=tab ; i++) {
		addInputField(i, tanggalSiaran[i-1], jamMulaiSiaran[i-1], jamSelesaiSiaran[i-1]);
	}
	$("#form").submit();
}

var removeTab = function(siaran) {
	$("#tab" + siaran).unbind();
	$("#tab" + siaran).remove();

	tanggalSiaran.pop();
	jamMulaiSiaran.pop();
	jamSelesaiSiaran.pop();

	if(activeTab == siaran) {
		chooseTab(siaran-1);
	}
};

$(document).ready(function() {

	$("#noOrder").prop("disabled", true);
	$("#jumlahSiaran").val(0);
	$("#siaranPerHari").val(0);

	$("#tanggal").datetimepicker({
		timepicker:false,
		format:"Y-m-d",
	});

	$("#jumlahSiaran").spinner({
		min: 0,
		max: 20,
	});

	$("#siaranPerHari").spinner({
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

	$("#jamMulaiSiaran").datetimepicker({
		datepicker:false,
		format: "H:i",
	});

	$("#jamSelesaiSiaran").datetimepicker({
		datepicker:false,
		format: "H:i",
	});

	chooseTab(0);

	$("#siaranPerHari").change(function() {
		currentTab = parseInt($("#siaranPerHari").val());

		if(tab < currentTab) {
			addTab(currentTab);
		} else {
			removeTab(tab);
		}

		tab = currentTab;
	});

	$("#button").click(function() {
		submitForm();
	});
});