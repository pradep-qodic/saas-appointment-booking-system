var apps=new Array();
var holi=new Array();
var startDT="";
$(document).ready(function() {
	$("#calendar").on("mouseenter",".fc-future",function(){
		$(this).append("<a data-toggle='modal' dt='"+$(this).attr('data-date')+"' data-target='#AppointmentModel' class='eAdd' onClick='showAppModel(this);' style='float:left;'><i class='fa fa-plus-square'></i></a>");
	});
	$("#calendar").on("mouseleave",".fc-future",function(){
		$(this).find(".eAdd").remove();
	});
	
	loadAppointmentTypes();
	$('body').on("change","#insp_type_id",function(){
		alert($("select#insp_type_id option:selected").val());
		
	});
	$("#btnAddAppointment").click(function(){
		addAppointment();
	});
	$("#selectSlots").click(function(){
		$('#orgslots').toggle('slow');
	});
	$('body').on("change","input[type=radio][name=slt]",function() {
		$("#startdate").val("");
        $("#startdate").val(startDT+" "+this.value);
    });
});
function loadTimeSlots(DATE){
	$.ajax({
        type:"post",
        data:{selected_date:DATE},
        url: $("#current_url").val()+'/loadTimeSlots',
        success: function(data){
			$("#orgslots").html("");
			if(data.status=="error"){
                $("#AppointmentEMsg").html(data.message);
                $('#AppointmentError').fadeIn().delay(5000).fadeOut();
				$("#orgslots").html(data.message);
				return;
			}
			for(var i=0;i<data.data.slots.length;i++){
				$("#orgslots").append("<label><input type='radio' value='"+data.data.slots[i]+"' name='slt'>&nbsp;&nbsp;"+data.data.slots[i]+"&nbsp;&nbsp;</label>");
			}
        }
    });
}
function addAppointment(){
	var d = $("#frmAppointment").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: $("#AddAppURL").val(),
        success: function(data){
            if(data.status=="success"){
                $("#AppointmentSMsg").html(data.message);
                $('#AppointmentSuccess').fadeIn().delay(3000).fadeOut(function(){location.reload();});
            }
			if(data.status=="error"){
                $("#AppointmentEMsg").html(data.message);
                $('#AppointmentError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function loadData(appID){
	$.ajax({
        type:"get",
        data:{},
		async:false,
        url: $("#loadHolidayURL").val(),
        success: function(data){
			holi=data.data.holidays;
        }
    });
	$.ajax({
		type:"get",
		data:{},
		sync:false,
		url: $("#current_url").val()+'/loadsessionAppData',
		success: function(data){
			apps=data.data.sessionAppointments;
			//fullCal(holi,apps);
		}
	});
	$.ajax({
		type:"post",
		data:{appointmentTypeId:appID},
		sync:false,
		url: $("#current_url").val()+'/loadUsersNotWorkingDays',
		success: function(data){
			fullCal(holi,apps,data.data.notWorkingDays);
		}
	});
}

function showAppModel(d){
	startDT=d.getAttribute('dt');
	$("#startdate").val(startDT);
	loadAppointmentTypes();
	loadTimeSlots(startDT);
}
function loadAppointmentTypes(){
	$.ajax({
        type:"get",
        data:{},
        url: $("#AddAppTypeURL").val(),
        success: function(data){
			$("#insp_type_id").html("");
           for(var i=0;i<data.data.app_types.length;i++){
				$("#insp_type_id").append("<option value='"+data.data.app_types[i]['inspectionTypeId']+"'>"+data.data.app_types[i]['typeName']+"</option>");
		   }
		   loadData($("select#insp_type_id option:selected").val());
        }
    });	
}

function fullCal(h,app,notWorking){
	//var list = new cookieList("schedularUserAppointments");
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		eventSources: [
        // your event source
        {
			events: h,
            color: 'red',     // an option!
            textColor: 'white', // an option!
        },
		{
            events: app,
            color: 'green',     // an option!
            textColor: 'white', // an option!
			editable: true,
			eventLimit: true // allow "more" link when too many events
        },
		{
            events: notWorking,
            color: 'red',     // an option!
            textColor: 'white', // an option!
        }
    ]
	});
}
