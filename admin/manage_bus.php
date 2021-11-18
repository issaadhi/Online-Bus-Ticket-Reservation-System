<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM bus_sch_list where id=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
	}
}

?>
<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-bus">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="" class="control-label">Bus</label>
						<select name="busId" id="busId" class="custom-select browser-default select2">
							<option></option>
							<?php 
							$busList = $conn->query("SELECT * FROM bus_list order by reg_No asc");
							while($row = $busList->fetch_assoc()):
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($bus_id) && $bus_id == $row['id'] ? "selected" : '' ?>><?php echo $row['reg_No'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Bus No</label>
						<textarea name="bus_no" id="" cols="30" rows="2" class="form-control"><?php echo isset($bus_no) ? $bus_no : '' ?></textarea>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<div class="">
						<label for="">Departure Location</label>
						<select name="departure_station_id" id="departure_location" class="custom-select browser-default select2">
							<option value=""></option>
						<?php
							$busStation = $conn->query("SELECT * FROM bus_station_list order by bus_station asc");
						while($row = $busStation->fetch_assoc()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($departure_station_id) && $departure_station_id == $row['id'] ? "selected" : '' ?>><?php echo $row['city'].", ".$row['bus_station'] ?></option>
						<?php endwhile; ?>
						</select>

					</div>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">Arrival Location</label>
						<select name="arrival_station_id" id="arrival_station_id" class="custom-select browser-default select2">

							<option value=""></option>

						<?php
							$busStation = $conn->query("SELECT * FROM bus_station_list order by bus_station asc");
						while($row = $busStation->fetch_assoc()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($arrival_station_id) && $arrival_station_id == $row['id'] ? "selected" : '' ?>><?php echo $row['city'].", ".$row['bus_station'] ?></option>
						<?php endwhile; ?>
						</select>

					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<div class="">
						<label for="">Departure Data/Time</label>
						<input type="text" name="departure_datetime" id="departure_datetime" class="form-control datetimepicker" value="<?php echo isset($departure_datetime) ? date("Y-m-d H:i",strtotime($departure_datetime)) : '' ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">Arrival Data/Time</label>
						<input type="text" name="arrival_datetime" id="arrival_datetime" class="form-control datetimepicker" value="<?php echo isset($arrival_datetime) ? date("Y-m-d H:i",strtotime($arrival_datetime)) : '' ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="">
						<label for="">Seats</label>
						<input name="seats" id="seats" type="number" step="any" class="form-control text-right" value="<?php echo isset($seats) ? $seats : '' ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">Price</label>
						<input name="price" id="price" type="number" step="any" class="form-control text-right" value="<?php echo isset($price) ? $price : '' ?>">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.select2').each(function(){
		$(this).select2({
		    placeholder:"Please select here",
		    width: "100%"
		  })
	})
	})
	 $('.datetimepicker').datetimepicker({
      format:'Y-m-d H:i',
  })
	 $('#manage-bus').submit(function(e){
	 	e.preventDefault()
	 	start_load()
	 	$.ajax({
	 		url:'ajax.php?action=save_busSch',
	 		method:'POST',
	 		data:$(this).serialize(),
	 		success:function(resp){
	 			if(resp == 1){
	 				alert_toast("Bus Details successfully saved.","success");
	 				setTimeout(function(e){
	 					location.reload()
	 				},1500)
	 			}
	 		}
	 	})
	 })
	 $('.datetimepicker').attr('autocomplete','off')
</script>