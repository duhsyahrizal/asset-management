<?php 
	include("connection.php");
	require_once('vigenere.php');
	$vigenere = new Vigenere($chiave);

	if ($_GET['data'] == 'kategori_aset') {
		$sql = "SELECT * FROM kategori_aset where id_kategori_aset = '".$_GET['id_kategori_aset']."'";
    	$result = $conn->query($sql);
     	$hasil = $result->fetch_assoc();
     	
     	echo json_encode($hasil);
	}else if ($_GET['data'] == 'kategori_lisensi') {
		$sql = "SELECT * FROM kategori_lisensi where id_kategori_lisensi = '".$_GET['id_kategori_lisensi']."'";
    	$result = $conn->query($sql);
     	$hasil = $result->fetch_assoc();
     	
     	echo json_encode($hasil);
	}elseif ($_GET['data'] == 'status') {
		$sql = "SELECT * FROM status where id_status = '".$_GET['id_status']."'";
    	$result = $conn->query($sql);
     	$hasil = $result->fetch_assoc();
     	
     	echo json_encode($hasil);
	}elseif ($_GET['data'] == 'lokasi') {
		$sql = "SELECT * FROM lokasi where id_lokasi = '".$_GET['id_lokasi']."'";
    	$result = $conn->query($sql);
     	$hasil = $result->fetch_assoc();
     	
     	echo json_encode($hasil);
	}elseif ($_GET['data'] == 'user') {
		$sql = "SELECT * FROM user where id_user = '".$_GET['id_user']."'";
    	$result = $conn->query($sql);
     	$hasil = $result->fetch_assoc();
     	
     	echo json_encode($hasil);
	}elseif ($_GET['data'] == 'aset') {
		$sql = "SELECT * FROM aset where aset_id = '".$_GET['aset_id']."'";
    $result = $conn->query($sql);
    $temp = [];
    $data = [];
    while($row = $result->fetch_assoc()){
      $temp['aset_id'] = $row['aset_id'];
      $temp['nik'] = $vigenere->decifratura($row['nik']);
      $temp['nama_karyawan'] = ucwords(strtolower($vigenere->decifratura($row['nama_karyawan'])));
	  $temp['divisi'] = ucwords(strtolower($vigenere->decifratura($row['divisi'])));
	  $temp['model'] = ucwords(strtolower($vigenere->decifratura($row['model'])));
      $temp['serialnumber'] = $vigenere->decifratura($row['serialnumber']);
      $temp['hostname'] = ucwords(strtolower($vigenere->decifratura($row['hostname'])));
      $temp['aset_kategori'] = $row['aset_kategori'];
      $temp['status'] = $row['status'];
      array_push($data, $temp);
    }
    echo json_encode($data);
				// echo "test";
    }elseif ($_GET['data'] == 'vigenere') {
        $user_id = $_SESSION['id_user'];
        if($_POST['vigenere_key'] == $chiave){
						$sql = "UPDATE status_cipher SET `status` = 1 WHERE user_id = $user_id";
						
						// $truncate_aset = "TRUNCATE TABLE aset";

						// $response = $conn->query($truncate_aset);
            if($conn->query($sql) === TRUE){
              echo "success";
            }
            else{
              echo "failed";
            }
        }
        else{
            echo "failed";
        }
		}
		elseif ($_GET['data'] == 'lisensi') {
			$sql = "SELECT * FROM lisensi where id_lisensi = '".$_GET['id_lisensi']."'";
			$result = $conn->query($sql);
			$temp = [];
			$data = [];
			while($row = $result->fetch_assoc()){
				$temp['id_lisensi'] = $row['id_lisensi'];
				$temp['nama_lisensi'] = ucwords(strtolower($vigenere->decifratura($row['nama_lisensi'])));
				$temp['banyak_lisensi'] = $row['banyak_lisensi'];
				$temp['serialnumber'] = $vigenere->decifratura($row['serialnumber']);
				$temp['kategori_lisensi'] = $row['kategori_lisensi'];
				$temp['status'] = $row['status'];
				array_push($data, $temp);
			}
			echo json_encode($data);
			// echo $data;
			}elseif ($_GET['data'] == 'vigenere') {
					$user_id = $_SESSION['id_user'];
					if($_POST['vigenere_key'] == $chiave){
							$sql = "UPDATE status_cipher SET `status` = 1 WHERE user_id = $user_id";
							
							// $truncate_aset = "TRUNCATE TABLE aset";
	
							// $response = $conn->query($truncate_aset);
							if($conn->query($sql) === TRUE){
								echo "success";
							}
							else{
								echo "failed";
							}
					}
					else{
							echo "failed";
					}
			}
 ?>