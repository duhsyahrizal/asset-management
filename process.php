<?php 

	include("connection.php");
	require_once('vigenere.php');
	$vigenere = new Vigenere($chiave);
	
	if ($_GET['action'] == "login") {
		$sql = "SELECT * FROM user WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."' AND status = 1";
				$result = $conn->query($sql);
				
		if (mysqli_num_rows($result) > 0) {
			while($hasil = $result->fetch_assoc()){
				$_SESSION['id_user'] = $hasil['id_user'];
				$_SESSION['nama'] = $hasil['nama'];
			}
			$_SESSION['username'] = $_POST['username'];
			echo '<script language="javascript">';
			echo 'alert("Selamat datang, '.$_SESSION['nama'].'");';
			echo 'window.location.href = "home.php";';
			echo '</script>';
		}else{
			echo '<script language="javascript">';
			echo 'alert("Periksa kembali username dan password Anda atau akun anda sudah tidak aktif, silakan hubungi pihak administrator");';
			echo 'window.location.href = "index.php";';
			echo '</script>';
		}
	}elseif ($_GET['action'] == "logout") {
		$user_id = $_SESSION['id_user'];
		$sql = "UPDATE status_cipher SET `status` = 0 WHERE user_id = $user_id";
		$conn->query($sql);
		session_unset();
		session_destroy();
		echo '<script language="javascript">';
		echo 'window.location.href = "index.php";';
		echo '</script>';
	}elseif ($_GET['action'] == "tambah_kategori_aset") {
		$nama_kategori_aset = $_POST['nama_kategori_aset'];

		$sql = "INSERT INTO kategori_aset VALUES (null, '$nama_kategori_aset')";
	    $result = $conn->query($sql);

		if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "edit_kategori_aset"){
		$nama_kategori_aset = $_POST['nama_kategori_aset'];
		$id_kategori_aset = $_POST['id_kategori_aset'];

		
	    $sql = "UPDATE kategori_aset SET nama_kategori_aset = '".$nama_kategori_aset."' WHERE id_kategori_aset = '".$id_kategori_aset."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "hapus_kategori_aset") {
		$sql = "DELETE FROM kategori_aset WHERE id_kategori_aset='".$_GET['id_kategori_aset']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif ($_GET['action'] == "tambah_kategori_lisensi") {
		$nama_kategori_lisensi = $_POST['nama_kategori_lisensi'];

		$sql = "INSERT INTO kategori_lisensi VALUES (null, '$nama_kategori_lisensi')";
	    $result = $conn->query($sql);

		if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "edit_kategori_lisensi"){
		$nama_kategori_lisensi = $_POST['nama_kategori_lisensi'];
		$id_kategori_lisensi = $_POST['id_kategori_lisensi'];

		
	    $sql = "UPDATE kategori_lisensi SET nama_kategori_lisensi = '".$nama_kategori_lisensi."' WHERE id_kategori_lisensi = '".$id_kategori_lisensi."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "hapus_kategori_lisensi") {
		$sql = "DELETE FROM kategori_lisensi WHERE id_kategori_lisensi='".$_GET['id_kategori_lisensi']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "assign_lisensi") {
		$id_lisensi = $_POST['id_lisensi'];
		$aset_id = $_POST['aset_id'];
		$sql = "INSERT INTO banyak_lisensi (`id_lisensi`, `aset_id`) VALUES ($id_lisensi, $aset_id)";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
		}
	}elseif($_GET['action'] == "hapus_assign_lisensi") {
		$sql = "DELETE FROM banyak_lisensi WHERE aset_id='".$_POST['aset_id']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "hapus_assign_aset") {
		$sql = "DELETE FROM banyak_lisensi WHERE aset_id='".$_POST['aset_id']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif ($_GET['action'] == "tambah_status") {
		$nama_status = $_POST['nama_status'];

		$sql = "INSERT INTO status VALUES (null, '$nama_status')";
	    $result = $conn->query($sql);

		if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "edit_status"){
		$nama_status = $_POST['nama_status'];
		$id_status = $_POST['id_status'];

		
	    $sql = "UPDATE status SET nama_status = '".$nama_status."' WHERE id_status = '".$id_status."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "hapus_status") {
		$sql = "DELETE FROM status WHERE id_status='".$_GET['id_status']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif ($_GET['action'] == "tambah_user") {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$nama = $_POST['nama'];
		$role = $_POST['role'];
		$status = $_POST['status'];
		
		$sql = "INSERT INTO user (`username`, `password`, `nama`, `role`, `status`) VALUES ('".$username."', '".$password."', '".$nama."', $role, $status)";
		// $insStatus = "INSERT INTO status_cipher (`status`, `user_id`)"
		$result = $conn->query($sql);
		
		if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "edit_user"){
		$id_user = $_POST['id_user'];
		$nama = $_POST['nama'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$status = $_POST['status'];

		
	    $sql = "UPDATE user SET username = '".$username."', password = '".$password."', nama = '".$nama."', role = $role, status = $status WHERE id_user = '".$id_user."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "hapus_user") {
		$sql = "DELETE FROM user WHERE id_user='".$_GET['id_user']."'";
		$sqlRemoveStatus = "DELETE FROM status_cipher WHERE user_id='".$_GET['id_user']."'";
		// remove row on status_cipher
		$conn->query($sqlRemoveStatus);
	  
	  if ($conn->query($sql) === TRUE) {
	  	echo 'success';
	  }else{
	  	echo 'failed';
	  }
	}elseif ($_GET['action'] == "tambah_status_user") {
		$status = $_POST['status_cipher'];
		
		$sql = "SELECT * FROM user";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$id_user = $row['id_user'];
		}
		$insStatus = "INSERT INTO status_cipher (`status`, `user_id`) VALUES ('".$status."', '".$id_user."')";

		if($conn->query($insStatus) === TRUE) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}

	elseif ($_GET['action'] == "tambah_aset") {
		$nik = $vigenere->cifratura($_POST['nik']);
		$nama_karyawan = $vigenere->cifratura($_POST['nama_karyawan']);
		$model = $vigenere->cifratura($_POST['model']);
		$divisi = $vigenere->cifratura($_POST['divisi']);
		$serialnumber = $vigenere->cifratura($_POST['serialnumber']);
		$hostname = $vigenere->cifratura($_POST['hostname']);
		$status = $_POST['status'];
		$aset_kategori = $_POST['aset_kategori'];
		$aset_input_date = date('Y-m-d');

		$sql = "INSERT INTO aset (`nik`, `nama_karyawan`, `model`, `divisi`, `serialnumber`, `hostname`, `status`,`aset_kategori`, `aset_input_date`, `created_by`) VALUES ('".$nik."', '".$nama_karyawan."', '".$model."', '".$divisi."',  '".$serialnumber."', '".$hostname."', $status, $aset_kategori, '".$aset_input_date."', '".$_SESSION['username']."')";
	    

		if ($conn->query($sql) === TRUE) {
	    	echo 'success';
	    }else{
			echo $conn->error;
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "edit_aset"){
		$aset_id = $_POST['aset_id'];
		$nik = $vigenere->cifratura($_POST['nik']);
		$nama_karyawan = $vigenere->cifratura($_POST['nama_karyawan']);
		$serialnumber = $vigenere->cifratura($_POST['serialnumber']);
		$divisi = $vigenere->cifratura($_POST['divisi']);
		$model = $vigenere->cifratura($_POST['model']);
		$hostname = $vigenere->cifratura($_POST['hostname']);
		$status = $_POST['status'];
		$aset_kategori = $_POST['aset_kategori'];
		
	    $sql = "UPDATE aset SET nik = '".$nik."', nama_karyawan = '".$nama_karyawan."', hostname = '".$hostname."', divisi = '".$divisi."',  model = '".$model."', serialnumber = '".$serialnumber."', status = '".$status."', aset_kategori = '".$aset_kategori."', updated_by = '".$_SESSION['username']."' WHERE aset_id = $aset_id";
	    $result = $conn->query($sql);
	    if ($result) {
				echo 'success';
	    }else{
				echo 'failed';
				echo $conn->error;
	    }
	}elseif($_GET['action'] == "hapus_aset") {
		$sql = "DELETE FROM aset WHERE aset_id='".$_GET['aset_id']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
	    	echo 'failed';
	    }
	}elseif ($_GET['action'] == "tambah_lisensi") {
		$nama_lisensi = $vigenere->cifratura($_POST['nama_lisensi']);
		$kategori_lisensi = $_POST['kategori_lisensi'];
		$serialnumber = $vigenere->cifratura($_POST['serialnumber']);
		$banyak_lisensi = $_POST['banyak_lisensi'];
		$status = $_POST['status'];
		$lisensi_input_date = date('Y-m-d');

		$sql = "INSERT INTO lisensi (`nama_lisensi`, `kategori_lisensi`, `serialnumber`, `banyak_lisensi`, `status`, `lisensi_input_date`, `created_by`) VALUES ('".$nama_lisensi."', $kategori_lisensi, '".$serialnumber."', '".$banyak_lisensi."', $status, '".$lisensi_input_date."', '".$_SESSION['username']."')";
	    

		if ($conn->query($sql) === TRUE) {
	    	echo 'success';
	    }else{
			echo $conn->error;
	    	echo 'failed';
	    }
	}elseif($_GET['action'] == "edit_lisensi"){
		$id_lisensi = $_POST['id_lisensi'];
		$nama_lisensi = $vigenere->cifratura($_POST['nama_lisensi']);
		$serialnumber = $vigenere->cifratura($_POST['serialnumber']);
		$banyak_lisensi = $_POST['banyak_lisensi'];
		$kategori_lisensi = $_POST['kategori_lisensi'];
		$status = $_POST['status'];
		
	    $sql = "UPDATE `lisensi` SET `kategori_lisensi`='".$kategori_lisensi."',`nama_lisensi`='".$nama_lisensi."',`banyak_lisensi`='".$banyak_lisensi."',`status`='".$status."',`serialnumber`='".$serialnumber."', `updated_by` = '".$_SESSION['username']."' WHERE id_lisensi = $id_lisensi";
			// echo json_encode($result);
	    if ($conn->query($sql) === TRUE) {
	    	echo 'success';
	    }else{
				echo 'failed<br>';
				echo $conn->error;
	    }
	}elseif($_GET['action'] == "hapus_lisensi") {
		$sql = "DELETE FROM lisensi WHERE id_lisensi='".$_GET['id_lisensi']."'";
	    $result = $conn->query($sql);
	    
	    if ($result) {
	    	echo 'success';
	    }else{
				echo 'failed';
				
	    }
	}
 ?>