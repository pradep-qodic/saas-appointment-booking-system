$(document).ready(function() {
	$("#calendarAdminDashboard").on("click",".fc-basicWeek-button",function(){
		$('#calendarAdminDashboard').fullCalendar('destroy');
		adminDashboardCalendar('basicWeek');
	});
	$("#calendarAdminDashboard").on("click",".fc-basicDay",function(){
		$('#calendarAdminDashboard').fullCalendar('destroy');
		adminDashboardCalendar('basicDay');
	});
	$('body').on("change","#dropdownPageList",function(){
		$('#calendarAdminDashboard').fullCalendar('destroy');
		adminDashboardCalendar('month');
	});
	adminDashboardCalendar('month');
});
function betweenDates(start,end){
	var d = start.substr(8, 2);
	var m = start.substr(5, 2) - 1;
	var y = start.substr(0, 4);
	
	var d1 = end.substr(8, 2);
	var m1 = end.substr(5, 2) - 1;
	var y1 = end.substr(0, 4);
	var currentDate = new Date(y, m, d),
        between = []
    ;
		
    while (new Date(y, m, d) <= new Date(y1, m1, d1)) {
		var date = new Date(currentDate);
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
        between.push(y+"-"+(m+1)+"-"+d);
        currentDate.setDate(currentDate.getDate() + 1);
    }
   return between;
}
function calHolidays(start, end, timezone, callback) {
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
		url: $("#base_url").val()+'/loadPageHolidaysData',
		type:"post",
		data:{pageId:pId},
		success: function(data) {
			holidays=data.data.holidays;
			if(holidays.length>0){
				for(var i=0;i<holidays.length;i++){
					var bDates=betweenDates(holidays[i].start,holidays[i].end);
					bDates.pop();
					for(var j=0;j<bDates.length;j++){
						$('.fc-day[data-date="' + bDates[j] + '"]').css('background',"#ebebeb");
						$('.fc-day[data-date="' + bDates[j] + '"]').attr("holiday","true");
					}
				}
			}
			callback(holidays);
		}
	});
}
function loadCalAppointments(start, end, timezone, callback) {
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
		url: $("#base_url").val()+'/loadPageAppointments',
		type:"post",
		data:{pageId:pId},
		success: function(data) {
			appointments=data.data.appointments;
			callback(appointments);
		}
	});
}
function calNotWorkingDays(start, end, timezone, callback) {
	var pId=$("select#dropdownPageList option:selected").val();
	var start=new Date(start);
	var end=new Date(end);
	$.ajax({
		url: $("#base_url").val()+'/loadPageNotWorkingDays',
		type:"post",
		data:{pageId:pId},
		success: function(data) {
			if(data.status=='success'){
				orgNotWorking=data.data.notWorkingDays;
				weekEnds=orgNotWorking;
				if(weekEnds && weekEnds.length>0){
					for(var i=0;i<weekEnds.length;i++) {
						var day=weekEnds[i];
						var dayVal = day.substring(0, 3);
						$('.fc-day.fc-'+dayVal+'').css('background',"#ebebeb");
					};
				}
			}
		}
	});
}
function adminDashboardCalendar(view){
	$('#calendarAdminDashboard').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		height: "auto",
		defaultView:view,
		theme:true,
		themeButtonIcons:false,
		firstDay:1,
		eventClick: calendarAppointmentClick,
		eventSources: [
        // your event source
        {
			events: calHolidays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
			className:'notWorking',
			editable: false
        },
		{
            events: loadCalAppointments,
			editable: true,
			eventLimit: true // allow "more" link when too many events
        },
		{
            events:calNotWorkingDays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
			className:'notWorking',
			editable: false
        }
    ]
	});
}
calendarAppointmentClick = function(event, jsEvent, view) {	
		if(event.id !=='undefined' && event.id !==undefined)
			loadUserAppointmentPage(event.id);
}
function loadUserAppointmentPage(id){
	$.ajax({
		type:"post",
		data:{app_id:id},
		url: $("#base_url").val()+'/userAppPage',
		success: function(data){
			if(data){
				$("body").html(data);
				$("#loader").fadeOut();
			}	
		}
	});
}
function getDayVal(v){
	switch(v.toUpperCase()){
		case "SUNDAY":
			return "0";
			break;
		case "MONDAY":
			return "1";
			break;
		case "TUESDAY":
			return "2";
			break;
		case "WEDNESDAY":
			return "3";
			break;
		case "THURSDAY":
			return "4";
			break;
		case "FRIDAY":
			return "5";
			break;
		case "SATURDAY":
			return "6";
			break;
		default:
			return "";
	}
}