<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Booked Ticket List</b>
				</large>
				
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="bus-list">
					<colgroup>
						<col width="10%">
						<col width="30%">
						<col width="50%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Information</th>
							<th class="text-center">Bus Info</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$airport = $conn->query("SELECT * FROM bus_station_list ");
							while($row = $airport->fetch_assoc()){
								$aname[$row['id']] = ucwords($row['bus_station'].', '.$row['city']);
							}
							$i=1;
							$qry = $conn->query("SELECT b.*,f.*,a.reg_No,a.logo_path,b.id as bid FROM  booked_ticket b inner join bus_sch_list f on f.id = b.bus_id inner join bus_list a on f.bus_id = a.id  order by b.id desc");
							while($row = $qry->fetch_assoc()):

						 ?>
						 <tr>
						 	
						 	<td><?php echo $i++ ?></td>
						 	<td>
						 		<p>Name :<b><?php echo $row['name'] ?></b></p>
						 		<p><small>Contact # :<b><?php echo $row['contact'] ?></small></b></p>
						 		<p><small>Address :<b><?php echo $row['address'] ?></small></b></p>
						 	</td>
						 	<td>
						 		<div class="row">
						 		<div class="col-sm-4">
						 			<img src="../assets/img/<?php echo $row['logo_path'] ?>" alt="" class="btn-rounder badge-pill">
						 		</div>
						 		<div class="col-sm-6">
						 		<p>Name :<b><?php echo $row['reg_No'] ?></b></p>
						 		<p><small>Bus :<b><?php echo $row['bus_no'] ?></small></b></p>
						 		<p><small>Name :<b><?php echo $row['reg_No'] ?></small></b></p>
						 		<p><small>Location :<b><?php echo $aname[$row['departure_station_id']].' - '.$aname[$row['arrival_station_id']] ?></small></b></p>
						 		<p><small>Departure :<b><?php echo date('M d,Y h:i A',strtotime($row['departure_datetime'])) ?></small></b></p>
						 		<p><small>Arrival :<b><?php echo date('M d,Y h:i A',strtotime($row['arrival_datetime'])) ?></small></b></p>
						 		</div>
						 		</div>
						 	</td>
						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_booked" type="button" data-id="<?php echo $row['bid'] ?>"><i class="fa fa-edit"></i></button>
						 			<button class="btn btn-outline-danger btn-sm delete_booked" type="button" data-id="<?php echo $row['bid'] ?>"><i class="fa fa-trash"></i></button>
						 	</td>

						 </tr>

						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#bus-list').dataTable()
	$('#new_booked').click(function(){
		uni_modal("New Detail","manage_booked.php",'mid-large')
	})
	$('.edit_booked').click(function(){
		uni_modal("Edit Information","manage_booked.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_booked').click(function(){
		_conf("Are you sure to delete this data?","delete_booked",[$(this).attr('data-id')])
	})
function delete_booked($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_booked',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Details successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>