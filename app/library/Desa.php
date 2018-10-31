<?php

function list_album($id=""){
	global $db, $_SESSION;
	
	$get_id		= isset($_SESSION['ID']) ? $_SESSION['ID'] : '';
	$user_role	= get_user_meta($get_id, 'user_level');
	$kode_desa 	= get_user_meta($get_id, 'kode_desa');
	
	$sql = "select * from wp_album";
	if($id) $sql .= " WHERE album_id='".$id."'";
	if($user_role < 4){
		//$sql .= " WHERE kode_desa='".$kode_desa."'";
	}
	$sql .= " ORDER BY album_id DESC";
	//print_r ($sql);
	
	$res = $db->query($sql);
	if($res){
		$data = array();
		while($row = $res->fetch_assoc()){
			$data[] = $row;
		}	
		return $data;
	}
}
function del_list_files($filename){
	global $db;
	
	$sql = "delete from wp_album_files where files_name='".$filename."'";
	//print_r ($sql);
	if($filename) $res = $db->query($sql);
}

function list_files($id){
	global $db;
	
	$nama_album = list_album($id);
	//var_dump ($nama_album);
	
	$sql = "select * from wp_album_files where files_album='".$id."'";
	$res = $db->query($sql);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$data[] = $row;
		}
		return array(
			'nama_album' => $nama_album[0]['nama_album'],
			'desc_album' => $nama_album[0]['desc_album'],
			'data' => $data
		);
	}
}

function simpan_album_files($newdata){
	global $db;
	
	$columns = implode("`, `", array_keys($newdata));
	$escaped_values = array_values($newdata);
	$values  = implode("', '", $escaped_values);
		
	$sql_query = "INSERT INTO wp_album_files (`".$columns."`) VALUES ('".$values."')";
	//print_r ($sql_query);
	$result = $db->query($sql_query);
}

function save_album($newdata){
	global $db;
	
	$double_album = double_album($newdata);
	
	$columns = implode("`, `", array_keys($newdata));
	$escaped_values = array_values($newdata);
	$values  = implode("', '", $escaped_values);
		
	$sql_query = "INSERT INTO wp_album (`".$columns."`) VALUES ('".$values."')";
	$result = $db->query($sql_query);
	if($result){		
		return json_encode(array('result' => 'success', 'id' => $db->insert_id));
	}
}

function double_album($newdata){
	global $db;
	
	if($newdata['kode_desa'] && $newdata['nama_album']){
		$sql = "select * from wp_album where kode_desa='".$newdata['kode_desa']."' AND nama_album='".$newdata['nama_album']."'";
		//print_r ($sql);
		$result = $db->query($sql);
		return $result->num_rows;
	}
}

function save_wp_bukuinduk($data){
	global $db;
	
	$columns = implode("`, `",array_keys($data));
	//$escaped_values = array_map('mysql_real_escape_string', array_values($data));
	$values  = implode("', '", array_values($data));
	
	$sql = "INSERT INTO `wp_bukuinduk` (`$columns`) VALUES ('$values')";
	//print_r ($sql);
	$result = $db->query($sql);
	if (!$result) {
		printf("Errormessage: %s\n", $db->error);
	}
    return $result;
}

function get_tipe($tipe){
	$tipe	= strtoupper($tipe);
	if($tipe == "PROVINSI"){
		$tipe = "KABUPATEN";
	}elseif($tipe == "KABUPATEN"){
		$tipe = "KECAMATAN";
	}elseif($tipe == "KECAMATAN"){
		//$tipe = "KELURAHAN";
	//}elseif($tipe == "KELURAHAN"){
		$tipe = "DESA";
	}
	
	return $tipe;
}

function desa_list($tipe,$kode=""){
	global $db;
	
	$tipe	= get_tipe($tipe);	
	if($kode){
		if(strlen($kode)==2){
			$sql = "SELECT * FROM wp_bukuinduk a LEFT JOIN wp_bukuinduk_data b ON b.idbukuinduk=a.id WHERE a.parent LIKE '%".$kode."%' AND a.tipe ='".$tipe."'";
		}else{
			$sql = "SELECT * FROM wp_bukuinduk a LEFT JOIN wp_bukuinduk_data b ON b.idbukuinduk=a.id WHERE a.parent = '".$kode."'";
		}
	}else{
		$sql = "SELECT * FROM wp_bukuinduk a LEFT JOIN wp_bukuinduk_data b ON b.idbukuinduk=a.id WHERE a.tipe='PROVINSI' AND kode='35'";
	}
	
	$sql .= " ORDER BY kode ASC";
	//print_r ($sql);
	
	$data = array();
	$res = $db->query($sql);
	while($row = $res->fetch_array()){
		$data[] = $row;
	}
	
	return $data;
}

function get_desaID($nama){
	global $db;	
	$sql = $db->query("select kode,parent from wp_bukuinduk where nama='$nama'");
	$res = $sql->fetch_assoc();
	return array(
		'kode' => $res['kode'],
		'parent' => $res['parent']
	);
	$db->free();
}

function get_desa($kode){
	global $db;	
	
	$qry = "select nama from wp_bukuinduk where kode='$kode'";
	//print_r ($qry);
	$sql = $db->query($qry);
	$res = $sql->fetch_assoc();
	return $res['nama'];
	$db->free();
}

function get_desa_cat($kode){
	global $db;
	$qry = "select name from wp_danadesa_cat where danacat_id='$kode'";
	$sql = $db->query($qry);
	$res = $sql->fetch_assoc();
	return $res['name'];
	$db->free();
}

function desa_education($tipe="", $parent=''){
	global $db;
	
	$tipe	= get_tipe($tipe);
	if($parent){
		if(strlen($parent)==2){
			$sql = "/*qc=on*/ SELECT * FROM wp_bukuinduk a LEFT JOIN wp_education b ON b.desa_kode=a.kode WHERE a.parent LIKE '%".$parent."%' AND a.tipe ='".$tipe."'";
		}else{
			$sql = "/*qc=on*/ SELECT * FROM wp_bukuinduk a LEFT JOIN wp_education b ON b.desa_kode=a.kode WHERE a.parent = '".$parent."'";
		}
	}else{
		$sql = "/*qc=on*/ SELECT * FROM wp_bukuinduk a LEFT JOIN wp_education b ON b.desa_kode=a.kode WHERE a.tipe='PROVINSI' AND kode='35'";
	}
	
	$sql .= " ORDER BY kode ASC";
	//print_r ($sql);
	
	$data = array();
	$res = $db->query($sql);
	while($row = $res->fetch_array()){
		$data[] = $row;
	}
	
	return $data;
	$res->free();
}

function list_bykecamatan($kode='35.15'){
	global $db;
	
	$res = $db->query("select * from wp_bukuinduk where parent='".$kode."'");
	while($row = $res->fetch_array()){
		$kecamatan[] = $row;
	}
	return $kecamatan;
}

function get_kecamatan($kode='35.15'){
	global $db;
	
	$res = $db->query("select * from wp_bukuinduk where kode='".$kode."'");
	$row = $res->fetch_array();
	return $row['nama'];
}

function save_edu($data){
	global $db;
	
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_education (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$db->query($sql_query);
	return $db->insert_id;
}

function save_pejabat($data){
	global $db;
	
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_pejabat (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$db->query($sql_query);
	return $db->insert_id;
}

function update_pejabat($data,$id){
	global $db;
		
	foreach($data as $key=>$value){
		//if(!empty($value)){
			$key = $db->real_escape_string($key);
			$value = $db->real_escape_string($value);
			$result[] = $key." = '".$value."'";
        //}
    }
	
    $query = "UPDATE wp_pejabat SET ".implode(', ',$result)." WHERE pejabat_id='".$id."'";
    //print_r ($query)."<br>";
	$res = $db->query($query);
}

function save_category($data){
	global $db;
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_education (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$db->query($sql_query);
	return $db->insert_id;
}

function sum_edu($type="edu_sd",$kode=""){
	global $db;
	
	$sql = $db->query("select sum($type) as tot from wp_education where desa_kode like '%$kode%'");
	$res = $sql->fetch_assoc();
	return $res['tot'];
	$db->free();
}

// Sumber  Dana DESA
function list_sumberdana(){
	global $db;
	$sql = $db->query("select * from wp_danadesa_cat");
	while($row = $sql->fetch_array()){
		$data[] = $row;
	}
	return $data;
	$db->free();
}

// List Pejabat Desa
function list_pejabat(){
	global $db;
	
	if(get_user_meta($_SESSION['ID'], 'user_level')==4){
		$qry = "select * from wp_pejabat";
	}else{
		$kode_desa	= get_user_meta($_SESSION['ID'], 'kode_desa');
		$qry = "select * from wp_pejabat where desa_kode='".$kode_desa."'";
	}
	//print_r ($qry);
	
	$sql = $db->query($qry);
	if($sql->num_rows > 0){
		while($row = $sql->fetch_array()){
			$data[] = $row;
		}
		return $data;
	}
}

// List Pejabat Desa
function get_pejabat($id){
	global $db;
	$sql = $db->query("select * from wp_pejabat where pejabat_id='".$id."'");
	if($sql->num_rows > 0){
		$data = $sql->fetch_array();
		return $data;
	}
	$db->free();
}


function get_danadesa_cat($kode){
	return get_desa_cat($kode);
}

function get_list_danadesa($kode_desa, $filter=array()){
	global $db;
	
	$filter['tahun'] = null;
	
	if($filter['tahun']==null){
		$filter['tahun'] = date('Y');
	}
	
	$qry = "select * from wp_danadesa a
	left join wp_danadesa_cat b ON b.danacat_id=a.sumber_dana
	where a.kode_desa = '$kode_desa'";
	
	if($filter['tahun']) $qry .= " AND tahun_dana='".$filter['tahun']."'";
	//echo ($qry)."<br>";
	
	$sql = $db->query($qry);
	if($sql->num_rows > 0){
		while($row = $sql->fetch_array()){
			$data[] = $row;
		}
		return $data;
	}
	//$db->free();
}

function get_danadesa($field='*',$kode_desa){
	global $db;
	
	//$query = "select $field from wp_danadesa where kode_desa='$kode_desa'";
	if($field=="sumber_dana"){
		$qry = "select $field from wp_danadesa where kode_desa='$kode_desa'";
	}elseif(strlen($kode_desa) > 8){
		$qry = "select sum($field) as $field from wp_danadesa where kode_desa='$kode_desa'";
	}else{
		$qry = "select sum($field) as $field from wp_danadesa where kode_desa like '$kode_desa%'";
	}
	//echo ($qry)."<br>";
	
	$sql = $db->query($qry);
	$res = $sql->fetch_assoc();
	if($field=="jumlah_dana"){
		$number = (int)$res[$field];
		return ($number);
	}elseif($field=="sumber_dana"){
		$cat = $res[$field];
		return get_danadesa_cat($cat);
	}else{
		return $res[$field];
	}
	$db->free();
}

function get_realisasi($field='*',$kode_desa){
	global $db;
	
	//echo strlen($kode_desa)."<br>";	
	if($field=="sumber_dana"){
		$qry = "select $field from wp_danadesa where kode_desa='$kode_desa'";
	}if(strlen($kode_desa) > 8){
		$qry = "select $field from wp_realisasidesa where kode_desa='$kode_desa'";
	}else{
		$qry = "select $field from wp_realisasidesa where kode_desa like '$kode_desa%'";
	}
	//echo ($qry)."<br>";
	
	$sql = $db->query($qry);
	$res = $sql->fetch_assoc();
	if($field=="jumlah_dana"){
		$number = intval($res[$field]);
		return ($number);
	}elseif($field=="sumber_dana"){
		$cat = $res[$field];
		return get_danadesa_cat($cat);
	}else{
		return $res[$field];
	}
	$db->free();
}

function desa_listdanadesa($kode=""){
	global $db;
	
	$sql = "SELECT * FROM wp_danadesa WHERE kode_desa = '".$kode."'";
	//print_r ($sql);
	$res = $db->query($sql);
	if($res->num_rows > 0){
		while($row = $res->fetch_array()){
			$data[] = $row;
		}	
		return $data;
	}
	$db->free();
}

function save_danadesa($data){
	global $db;
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_danadesa (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$db->query($sql_query);
	return $db->insert_id;	
}

function save_realisasi($data){
	global $db;
	$columns = implode("`, `", array_keys($data));
	$escaped_values = array_values($data);
	$values  = implode("', '", $escaped_values);
	
	$sql_query = "INSERT INTO wp_realisasidesa (`".$columns."`) VALUES ('".$values."')";
	//echo $sql_query.'<br>';
	$db->query($sql_query);
	return $db->insert_id;	
}

function report_dana($kode){
	$dana 	= get_danadesa('jumlah_dana',$kode);
	$dana 	= isset($dana) ? $dana : 0;
	
	$real 	= get_realisasi('jumlah_dana',$kode);
	$real 	= isset($real) ? $real : 0;
	
	$sisa	= 0;
	$persen	= 0;
	
	if($real > 0){
		$sisa = intval($dana-$real);
	}
	
	if($sisa > 0){
		$persen = ($real/$dana)*100;
	}
	
	return array(
		'dana' => toIDR($dana),
		'real' => toIDR($real),
		'sisa' => toIDR($sisa),
		'persen' => round($persen, 2)
	);
}

function total_danadesa(){
	global $db;
	$sql = $db->query("select SUM(jumlah_dana) as tot, count(*) as desa from wp_danadesa");
	$res = $sql->fetch_assoc();
	return array(
		'tot' => $res['tot'],
		'tot_desa' => $res['desa']
	);
	$db->free();
}

function total_penduduk(){
	global $db;
	$sql = $db->query("select SUM(jml_penduduk) as tot from wp_bukuinduk_data");
	$res = $sql->fetch_assoc();
	return array(
		'tot' => $res['tot']
	);
	$db->free();
}