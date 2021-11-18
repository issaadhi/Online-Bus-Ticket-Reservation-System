
<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=booked" class="nav-item nav-booked"><span class='icon-field'><i class="fa fa-book"></i></span> Booked</a>
				<a href="index.php?page=bus" class="nav-item nav-bus"><span class='icon-field'><i class="fa fa-bus"></i></span> Bus List</a>
				<a href="index.php?page=bus_schedule" class="nav-item nav-buses"><span class='icon-field'><i class="fa fa-bus"></i></span> Bus Schedule List</a>
				<a href="index.php?page=stations" class="nav-item nav-stations"><span class='icon-field'><i class="fa fa-map-marked-alt"></i></span> Cities</a>		
				<!-- <a href="index.php?page=stations" class="nav-item nav-stations"><span class='icon-field'><i class="fa fa-building"></i></span> Company</a>		 -->
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cog"></i></span> Site Settings</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
