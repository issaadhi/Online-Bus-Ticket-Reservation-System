<?php 
include 'admin/db_connect.php'; 
?>
<style>
#portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
</style>
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                    	<h3 class="text-white">WELCOME!</h3>
                    <div class="col-md-12 mb-2 text-left">
                        <div class="card">
                            <div class="card-body">
                                <form id="manage-filter" action="index.php?page=buses" method="POST">
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">From</label>
                                            <select name="departure_station_id" id="departure_location" class="custom-select browser-default select2">
                                                <option value=""></option>
                                            <?php
                                                $bStation = $conn->query("SELECT * FROM bus_station_list order by bus_station asc");
                                            while($row = $bStation->fetch_assoc()):
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
                                                $bStation = $conn->query("SELECT * FROM bus_station_list order by bus_station asc");
                                            while($row = $bStation->fetch_assoc()):
                                            ?>
                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($arrival_station_id) && $arrival_station_id == $row['id'] ? "selected" : '' ?>><?php echo $row['city'].", ".$row['bus_station'] ?></option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">Departure Date</label>
                                            <input type="date" class="form-control input-sm datetimepicker2" name="date" autocomplete="off">
                                        </div>
                                        <div class="col-sm-3" id="rdate" style="display: none">
                                            <label for="" class="control-label">Return Date</label>
                                            <input type="date" class="form-control input-sm datetimepicker2" name="date_return" autocomplete="off">
                                        </div>
                                    </div> 
                                        <div class="col-sm-3 offset-sm-8">
                                            <button class="btn btn-block btn-sm btn-primary" type="submit"><i class="fa fa-bus"></i> | Find Your Bus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                        
                    </div>
                    
                </div>
            </div>
        </header>
	