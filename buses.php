<?php 
include 'admin/db_connect.php'; 
if($_SERVER['REQUEST_METHOD'] == "POST"){
	foreach($_POST as $k => $v){
		$$k = $v;
	}
}

?>
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                    	<h3 class="text-white">BUS LIST</h3>
                        <div class="col-md-12 mb-2 text-left">
                        <div class="card">
                            <div class="card-body">
                                <form id="manage-filter"  action="index.php?page=buses" method="POST">
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">From</label>
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
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">To</label>
                                            <select name="arrival_station_id" id="arrival_station_id" class="custom-select browser-default select2">

                                                <option value=""></option>

                                            <?php
                                                $bus_station = $conn->query("SELECT * FROM bus_station_list order by bus_station asc");
                                            while($row = $bus_station->fetch_assoc()):
                                            ?>
                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($arrival_station_id) && $arrival_station_id == $row['id'] ? "selected" : '' ?>><?php echo $row['city'].", ".$row['bus_station'] ?></option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">Departure Date</label>
                                            <input type="date" class="form-control input-sm datetimepicker2" name="date" autocomplete="off" value="<?php echo isset($date) && !empty($date) ? date("Y-m-d",strtotime($date)) : "" ?>">
                                        </div>
                                        <div class="col-sm-3 offset-sm-8">
                                            <button class="btn btn-block btn-sm btn-primary"><i class="fa fa-bus"></i> | Find Your Bus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                        
                    </div>
                    </div>
                    
                </div>
            </div>
        </header>
	<section class="page-section" id="bus" >
        <div class="container">
        	<div class="card">
        		<div class="card-body">
        			<div class="col-lg-12">
						<div class="row">
							<div class="col-md-12 text-center">
								<h2><b><?php echo isset($trip) && $trip == 2 ? "Departure Searched Bus results..." : ( !isset($trip)? " Buses Available " :"Searched Bus results...")  ?></b></h2>
							</div>
						</div>

				<?php 
				$bus_station = $conn->query("SELECT * FROM bus_station_list ");
				while($row = $bus_station->fetch_assoc()){
					$aname[$row['id']] = ucwords($row['bus_station'].', '.$row['city']);
				}
				$where = " where date(f.departure_datetime) > '".date("Y-m-d")."' ";
				if($_SERVER['REQUEST_METHOD'] == "POST" )
				$where .= " and f.departure_station_id ='$departure_station_id' and f.arrival_station_id = '$arrival_station_id' and date(f.departure_datetime) = '".date('Y-m-d',strtotime($date))."'  ";
				$bus = $conn->query("SELECT f.*,a.reg_No,a.logo_path FROM bus_sch_list f inner join bus_list a on f.bus_id = a.id $where order by rand()");
				if($bus->num_rows > 0):
				while($row=$bus->fetch_assoc()):
					$booked = $conn->query("SELECT * FROM booked_ticket where bus_id = ".$row['id'])->num_rows;
				?>
				<div class="row align-items-center">
					<div class="col-md-3">
						<img src="assets/img/<?php echo $row['logo_path'] ?>" alt="">
					</div>
					<div class="col-md-6">
						 <p><b><?php echo $aname[$row['departure_station_id']].' - '.$aname[$row['arrival_station_id']] ?></b></p>
						 <p><small>Bus: <b><?php echo $row['reg_No'] ?></b></small></p>
						 <p><small>Departure: <b><?php echo date('h:i A',strtotime($row['departure_datetime'])) ?></b></small></p>
						 <p><small>Arrival: <b><?php echo (date('M d,Y',strtotime($row['departure_datetime'])) == date('M d,Y',strtotime($row['arrival_datetime']))) ? date('h:i A',strtotime($row['arrival_datetime'])) : date('M d,Y h:i A',strtotime($row['arrival_datetime'])) ?></b></small></p>
						 <p>Available Seats : <b><h4><?php echo $row['seats'] - $booked ?></h4></b></p>
					</div>
					<div class="col-md-3 text-center align-self-end-sm">
						<h4 class="text-center"><b>Rs. <?php echo number_format($row['price'],2) ?></b></h4>
						<button class="btn-outline-primary  btn  mb-5 book_bus" type="button" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo $aname[$row['departure_station_id']].' - '.$aname[$row['arrival_station_id']] ?>" data-max="<?php echo $row['seats'] - $booked ?>">Book Now</button>
					</div>
				</div>

				<?php endwhile; ?>
				<?php else: ?>

					<div class="row align-items-center">
						<h5 class="text-center"><b>No result.</b></h5>
					</div>
				<?php endif; ?>
					
				<?php if(isset($trip) && $trip ==2): ?>
					<hr>
					<div class="row">
						<div class="col-md-12 text-center">
							<h2><b><?php echo isset($trip) && $trip == 2 ? "Arrival Searched Bus results..." : ( !isset($trip)? " Buses Available " :"Searched Bus results...")  ?></b></h2>
						</div>
					</div>
		
				<?php 
				$bus_station = $conn->query("SELECT * FROM bus_station_list ");
				while($row = $bus_station->fetch_assoc()){
					$aname[$row['id']] = ucwords($row['bus_station'].', '.$row['city']);
				}
				$where = " where date(f.departure_datetime) > '".date("Y-m-d")."' ";
				if($_SERVER['REQUEST_METHOD'] == "POST" )
				$where .= " and f.departure_station_id ='$arrival_station_id' and f.arrival_station_id = '$departure_station_id' and date(f.departure_datetime) = '".date('Y-m-d',strtotime($date_return))."'  ";
				$bus = $conn->query("SELECT f.*,a.reg_No,a.logo_path FROM bus_sch_list f inner join bus_list a on f.bus_id = a.id $where order by rand()");
				if($bus->num_rows > 0):
				while($row=$bus->fetch_assoc()):
					$booked = $conn->query("SELECT * FROM booked_ticket where bus_id = ".$row['id'])->num_rows;

				?>
				<div class="row align-items-center">
					<div class="col-md-3">
						<img src="assets/img/<?php echo $row['logo_path'] ?>" alt="">
					</div>
					<div class="col-md-6">
						 <p><b><?php echo $aname[$row['departure_station_id']].' - '.$aname[$row['arrival_station_id']] ?></b></p>
						 <p><small>Bus: <b><?php echo $row['reg_No'] ?></b></small></p>
						 <p><small>Departure: <b><?php echo date('h:i A',strtotime($row['departure_datetime'])) ?></b></small></p>
						 <p><small>Arrival: <b><?php echo (date('M d,Y',strtotime($row['departure_datetime'])) == date('M d,Y',strtotime($row['arrival_datetime']))) ? date('h:i A',strtotime($row['arrival_datetime'])) : date('M d,Y h:i A',strtotime($row['arrival_datetime'])) ?></b></small></p>
						 <p>Available Seats : <b><h4><?php echo $row['seats'] - $booked ?></h4></b></p>
					</div>
					<div class="col-md-3 text-center align-self-end-sm">
						<h4 class="text-center"><b>Rs. <?php echo number_format($row['price'],2) ?></b></h4>
						<button class="btn-outline-primary  btn  mb-4 book_bus" type="button" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo $aname[$row['departure_station_id']].' - '.$aname[$row['arrival_station_id']] ?>" data-max="<?php echo $row['seats'] - $booked ?>">Book Now</button>
					</div>
				</div>
				
				<?php endwhile; ?>
				<?php else: ?>

					<div class="row align-items-center">
						<h5 class="text-center"><b>No result.</b></h5>
					</div>
				<?php endif; ?>
				<?php endif; ?>
				</div>
				</div>
        	</div>
        </div>
    </section>
    <style>
    	#bus img{
    		max-height: 300px;
    		max-width: 200px; 
    	}
    	#bus p{
    		margin: unset
      	}
    </style>
    <script>
       
       $('.book_bus').click(function(){
       	if($(this).attr('data-max') <= 0){
       		alert("There is no Available Seats for the selected bus");
       		return false;
       	}
			uni_modal($(this).attr('data-name'),"book_bus.php?id="+$(this).attr('data-id')+"&max="+$(this).attr('data-max'),'mid-large')
		})
        $('[name="trip"]').on("keypress change keyup",function(){
            if($(this).val() == 1){
                $('#rdate').hide()
            }else{
                $('#rdate').show()
            }
        })
    </script>
	
