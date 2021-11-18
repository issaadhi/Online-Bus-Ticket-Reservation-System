<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Bus schedule List</b>
				</large>
				<button class="btn btn-primary btn-block col-md-2 float-right" type="button" id="new_bus"><i class="fa fa-plus"></i> New Bus</button>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="bus-list">
					<colgroup>
						<col width="10%">
						<col width="35%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">Date</th>
							<th class="text-center">Information</th>
							<th class="text-center">Seats</th>
							<th class="text-center">Booked</th>
							<th class="text-center">Available</th>
							<th class="text-center">Price</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$bStation = $conn->query("SELECT * FROM bus_station_list ");
							while($row = $bStation->fetch_assoc()){
								$aname[$row['id']] = ucwords($row['bus_station'].', '.$row['city']);
							}
							$qry = $conn->query("SELECT f.*,a.reg_No,a.logo_path FROM bus_sch_list f inner join bus_list a on f.bus_id = a.id  order by id desc");
							while($row = $qry->fetch_assoc()):
								$booked = $conn->query("SELECT * FROM booked_ticket where bus_id = ".$row['id'])->num_rows;

						 ?>
						 <tr>
						 	
						 	<td><?php echo date('M d,Y',strtotime($row['date_created'])) ?></td>
						 	<td>
						 		<div class="row">
						 		<div class="col-sm-4">
						 			<img src="../assets/img/<?php echo $row['logo_path'] ?>" alt="" class="btn-rounder badge-pill">
						 		</div>
						 		<div class="col-sm-6">
						 		<p>Bus :<b><?php echo $row['reg_No'] ?></b></p>
						 		<!-- <p><small>Bus :<b><?php echo $row['reg_No'] ?></small></b></p> -->
						 		<p><small>Bus Station :<b><?php echo $aname[$row['departure_station_id']].' - '.$aname[$row['arrival_station_id']] ?></small></b></p>
						 		<p><small>Departure :<b><?php echo date('M d,Y h:i A',strtotime($row['departure_datetime'])) ?></small></b></p>
						 		<p><small>Arrival :<b><?php echo date('M d,Y h:i A',strtotime($row['arrival_datetime'])) ?></small></b></p>
						 		</div>
						 		</div>
						 	</td>
						 	<td class="text-right"><?php echo $row['seats'] ?></td>
						 	<td class="text-right"><?php echo $booked ?></td>
						 	<td class="text-right"><?php echo $row['seats'] - $booked ?></td>
						 	<td class="text-right"><?php echo number_format($row['price'],2) ?></td>
						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_details" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 			<button class="btn btn-outline-danger btn-sm delete_details" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button>
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
	$('#new_bus').click(function(){
		uni_modal("New Bus","manage_bus.php",'mid-large')
	})
	$('.edit_details').click(function(){
		uni_modal("Edit Bus","manage_bus.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_details').click(function(){
		_conf("Are you sure to delete this Bus?","delete_details",[$(this).attr('data-id')])
	})
function delete_details($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_busSch',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Bus successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>