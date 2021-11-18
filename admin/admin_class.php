<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function delete_user(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM users where id = ".$id);
        if($delete)
            return 1;
    }
	
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_busDetails(){
		extract($_POST);
		$data = " reg_No = '$reg_No' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$fname = strtotime(date("Y-m-d H:i"))."_".$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/'.$fname);
			if($move){
				$data .=", logo_path = '$fname' ";
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO bus_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE bus_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_busDetails(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM bus_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_stationDetails(){
		extract($_POST);
		$data = " bus_station = '$bus_station' ";
		$data .= ", city = '$city' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO bus_station_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE bus_station_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_stationDetails(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM bus_station_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_busSch(){
		extract($_POST);
		$data = " bus_id = '$busId' ";
		$data .= ", bus_no = '$bus_no' ";
		$data .= ", departure_station_id = '$departure_station_id' ";
		$data .= ", arrival_station_id = '$arrival_station_id' ";
		$data .= ", departure_datetime = '$departure_datetime' ";
		$data .= ", arrival_datetime = '$arrival_datetime' ";
		$data .= ", seats = '$seats' ";
		$data .= ", price = '$price' ";
		
		if(empty($id)){
			// echo "INSERT INTO Bus_schedule_list set ".$data;
			$save = $this->db->query("INSERT INTO bus_sch_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE bus_sch_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_busSch(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM bus_sch_list where id = ".$id);
		if($delete)
			return 1;
	}
	function book_ticket(){
		extract($_POST);
		foreach ($name as $k => $value) {
			$data = " bus_id = $bus_id ";
			$data .= " , name = '$name[$k]' ";
			$data .= " , address = '$address[$k]' ";
			$data .= " , contact = '$contact[$k]' ";

			$save[] = $this->db->query("INSERT INTO booked_ticket set ".$data);
		}
		if(isset($save))
			return 1;
	}
	function update_booked(){
		extract($_POST);
			$data = "  name = '$name' ";
			$data .= " , address = '$address' ";
			$data .= " , contact = '$contact' ";

			$save= $this->db->query("UPDATE booked_ticket set ".$data." where id =".$id);
		if($save)
			return 1;
	}
		function delete_booked(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM booked_ticket where id = ".$id);
		if($delete)
			return 1;
	}
}