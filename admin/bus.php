<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-bus">
				<div class="card">
					<div class="card-header">
						   Bus List Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Bus Registration Number</label>
								<textarea name="reg_No" id="" cols="30" rows="2" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Logo</label>
								<input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
							</div>
							<div class="form-group">
								<img src="" alt="" id="cimg">
							</div>	
							
							
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Image</th>
									<th class="text-center">Registration Number</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$cats = $conn->query("SELECT * FROM bus_list order by id asc");
								while($row=$cats->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<img src="../assets/img/<?php echo $row['logo_path'] ?>" alt="">
									</td>
									<td class="">
										 <b><?php echo $row['reg_No'] ?></b>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_details" type="button" data-id="<?php echo $row['id'] ?>" data-reg_No="<?php echo $row['reg_No'] ?>" data-logo_path="<?php echo $row['logo_path'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_details" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	function _reset(){
		$('#cimg').attr('src','');
		$('[name="id"]').val('');
		$('#manage-bus').get(0).reset();
	}
	
	$('#manage-bus').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_busDetails',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_details').click(function(){
		start_load()
		var cat = $('#manage-bus')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='reg_No']").val($(this).attr('data-reg_No'))
		cat.find("#cimg").attr("src","../assets/img/"+$(this).attr('data-logo_path'))
		end_load()
	})
	$('.delete_details').click(function(){
		_conf("Are you sure to delete this Details?","delete_details",[$(this).attr('data-id')])
	})
	function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
	function delete_details($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_busDetails',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>