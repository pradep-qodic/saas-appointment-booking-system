$(document).ready(function() {
	$('body').on('click','a.org_edit',function(e){
		var url=$(this).attr('data_org_url');
		var description=$(this).attr('data_org_description');
		var title=$(this).attr('data_org_title');
		var id=$(this).attr('data_id');
		var status=$(this).attr('data_org_status');
		
		$('#org_name').val(title);
		$('#org_desc').val(description);
		$('#org_url').val(url);
		$('#org_id').val(id);
		if(status=='1'){
			$('#Active').prop('checked',true);
		}else{
			$('#InActive').prop('checked',true);
		}		
	});
	$('body').on('click','a.org_delete',function(e){		
		var id=$(this).attr('data_id');
		$('#orgid').val(id);
	});
	$('body').on('click','#btnupdateOrg',function(e){
		updateOrganization();
	});
	$('body').on('click','#dlPlan',function(e){
		var id=$('#orgid').val();
		DeleteOrg(id);		
	});
});
function updateOrganization(){	
	var d = $("#frmUpdateOrg").serializeArray();
	var url=$("#base_url").val();	
	$.ajax({
        type:"post",
        data:d,
        url: url+"admins/updateOrganization",
        success: function(data){
            if(data.status=="success"){
                $("#generalSMsg").html(data.message);
                $('#generalSuccess').fadeIn().delay(3000).fadeOut(function(){
					$('#bookingPageModal').modal('hide');
					loadOrganizations();
				});
				
            }
			if(data.status=="error"){
                $("#generalEMsg").html(data.message);
                $('#generalError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}

function DeleteOrg(id){	
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{id:id},
        url: url+"admins/deleteOrganizations",
        success: function(data){
            if(data.status=="success"){
               $('#deleteWorkingPlanModel').modal('hide');
			   loadOrganizations();
            }
			
        }
    });
}
function loadOrganizations(){
	var url=$("#base_url").val();
	$.ajax({
        type:"get",
        data:{},
        url: url+"admins/loadOrganizations",
        success: function(data){			
			$('#LoadOrg').html(data);
        }
    });
}