<?php
session_start();
require_once "../models/Home.php";
$model = new Home;
$id = 0;
$arr = array();
if(!empty($_SESSION['booking'])){
	$arr = $_SESSION['booking'];
}

$infoArr = $_POST;

$arr = array_merge($arr, $infoArr);
$request = (int) $_POST["request"];
unset($arr['btnRegist']);
unset($arr['request']);

$arr['created_at'] = time();
$arr['updated_at'] = time();
$arr['status'] = 2;
foreach ($arr as $key => $value) {
	if($key == "depatureDate" || $key == "returnDate"){
		$arr[$key] = strtotime($value);
	}else{
		$arr[$key] = $model->processData($value);	
	}	
}

if($arr['depatureDate'] != '' && $arr['fullname'] != '' && $arr['email'] != '' && $arr['phone'] != ''){
	$id = $model->insert("booking",$arr);
}
if($id > 0){	
	
	$cityArr = $model->getListCity();
	$loaive = $arr['national_type'] == 1 ? "Nội địa" : "Quốc tế"; 
	$loaive .= " - ". ($arr['type'] == 1 ? "Một chiều" : "Khứ hồi");
	if($request == 0){
		if($arr['national_type'] == 1){ 
			$noi_di =  $cityArr[$arr['noi_di']]['city_name']." (".$cityArr[$arr['noi_di']]['city_code'].")";
			$noi_den =  $cityArr[$arr['noi_den']]['city_name']." (".$cityArr[$arr['noi_den']]['city_code'].")";
		}
		if($arr['national_type'] == 2){
			$noi_di = $arr['noi_di_ngoai'];
			$noi_den = $arr['noi_den_ngoai'];	
		}
	}else{
		$noi_di = $arr['noi_di_ngoai'];
		$noi_den = $arr['noi_den_ngoai'];		
	}
	$luong_khach = "Người lớn: ".$arr['adultNo'].", Trẻ em: ".$arr['childNo'].", Em bé:".$arr['infantNo'];
	$tieudethu="VEREAIRLINE.COM :: KHÁCH HÀNG ĐẶT VÉ";

	$noidungthu = '<table width="800px"><tr><td colspan="2" align="left"><h3>THÔNG TIN VÉ</h3></td></tr>';
	if($request == 0) $noidungthu .= '<tr><td width="200px">Loại vé:</td><td>'.$loaive.'</td></tr>';        
	$noidungthu .= '<tr><td width="200px">Nơi đi:</td><td>'.$noi_di.'</td></tr>';
	$noidungthu .= '<tr><td width="200px">Nơi đến:</td><td>'.$noi_den.'</td></tr>';
	$noidungthu .= '<tr><td width="200px">Ngày đi:</td><td>'.date('d-m-Y', $arr['depatureDate']).'</td></tr>';
	$noidungthu .= '<tr><td width="200px">Ngày về:</td><td>'.date('d-m-Y', $arr['returnDate']).'</td></tr>';
	if($request == 0) $noidungthu .= '<tr><td>Lượng hành khách:</td><td>'.$luong_khach.'</td></tr></table>';

	$noidungthu .= '<table width="800px"><tr><td colspan="2" align="left"><h3>THÔNG TIN LIÊN HỆ</h3></td></tr>';
	$noidungthu .= '<tr><td width="200px">Họ tên:</td><td>'.$arr['fullname'].'</td></tr>';        
	$noidungthu .= '<tr><td>Email:</td><td>'.$arr['email'].'</td></tr>';
	$noidungthu .= '<tr><td>Điện thoại:</td><td>'.$arr['phone'].'</td></tr>';
	if($request == 0) $noidungthu .= '<tr><td>Địa chỉ:</td><td>'.$arr['address'].'</td></tr>';
	$noidungthu .= '<tr><td>Ghi chú khác:</td><td>'.$arr['notes'].'</td></tr></table>';
    
    $email_nhan = 'pham.phuong003@yahoo.com.vn'; 
    $email_2 = 'phuongnscr@gmail.com';
    $model->smtpmailer($email_nhan, 'vereairline.com@gmail.com', 'vereairline.com',$tieudethu,$noidungthu); 
    $model->smtpmailer($email_2, 'vereairline.com@gmail.com', 'vereairline.com',$tieudethu,$noidungthu); 
    unset($_SESSION['booking']);
    echo "success";
}
?>