<?php	if(!defined('_source')) die("Error");
$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
switch($act){
	case "capnhat":
		get_gioithieu();
		$template = "cohoivieclam/item_add";
		break;
	case "save":
		save_gioithieu();
		break;

		
	default:
		$template = "index";
}
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;	
	}

function get_gioithieu(){
	global $d, $item;

	$sql = "select * from #_cohoivieclam limit 0,1";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu chưa khởi tạo.", "index.php");
	$item = $d->fetch_array();
}

function save_gioithieu(){
	global $d;
	$file_name=fns_Rand_digit(0,9,5);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=cohoivieclam&act=capnhat");
	if($photo = upload_image("file", 'jpg|png|gif|JPG|jpeg|JPEG',_upload_hinhanh,$file_name)){
			$data['photo'] = $photo;
			$d->setTable('cohoivieclam');			
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_hinhanh.$row['photo']);
			}
		}
	
	$data['noidung_vi'] = $_POST['noidung_vi'];
	$data['noidung_en'] = $_POST['noidung_en'];
	$data['mota_vi'] = $_POST['mota_vi'];
	$data['mota_en'] = $_POST['mota_en'];
	$data['meta'] = $_POST['meta'];
	$d->reset();
	$d->setTable('cohoivieclam');
	if($d->update($data))
		transfer("Dữ liệu được cập nhật", "index.php?com=cohoivieclam&act=capnhat");
	else
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=cohoivieclam&act=capnhat");
}

?>