<fieldset>
<legend><h1>Organizations</h1></legend>
	<div class="row">
		<div class="span12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Desc</th>
						<th>org_url</th>
						<th>is_deleted</th>
						<th>status</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($organizations as $org): ?>
					<tr>
						<td><?php echo $org->org_id; ?></td>
						<td><?php echo $org->org_title; ?></td>
						<td><?php echo $org->org_description; ?></td>
						<td><?php echo base_url1().$org->org_url; ?></td>
						<td><?php echo $org->is_deleted; ?></td>
						<td><?php echo $org->status; ?></td>
						<td><a href=""class="org_edit" data_org_status="<?php echo $org->status; ?>" data_org_url="<?php echo $org->org_url; ?>"  data_org_description="<?php echo $org->org_description; ?>" data_org_title="<?php echo $org->org_title; ?>" data_id="<?php echo $org->org_id; ?>" data-toggle="modal"  data-target="#bookingPageModal"><span class="fa fa-pencil"></span></a></td>
						<td><a href="" class="org_delete" data_id="<?php echo $org->org_id; ?>" data-toggle="modal" data-target="#deleteWorkingPlanModel"><span class="fa fa-trash-o"></span></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</fieldset>