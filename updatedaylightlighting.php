<?php
    $json = array();
    header('Content-Type:Application/json');
    header('Access-Control-Allow-Origin: *');
    include_once("include/db.php");
    global $con;
    if(isset($_POST['lux_meter'],$_POST['total_in_light'], $_POST['total_out_watt']
    , $_POST['watt_sensor'], $_POST['total_out_light'],$_POST['light_inspect'],
    $_POST['light_points'], $_POST['prop_id'], $_POST['userid'], $_POST['daylightid'])){
        $lux_meter = $_POST['lux_meter'];
        $no_led = null;
        if(empty($_POST['no_led']) && !isset($_POST['no_led'])){
            $no_led = 0;
        }else{
            $no_led = intval($_POST['no_led']);
        }
        $no_led_img = null;
        if(isset($_FILES['no_led_img'])){
            if(is_uploaded_file($_FILES['no_led_img']['tmp_name'])){
                $no_led_img = base64_encode(file_get_contents(addslashes($_FILES['no_led_img']['tmp_name'])));
            }
        }
        else{
            $no_led_img = null;
        }
        
        $no_fluo = null;
        if(empty($_POST['no_fluo']) && !isset($_POST['no_fluo']) ){
            $no_fluo = 0;
        }else{
            $no_fluo = intval($_POST['no_fluo']);
        }
        $no_fluo_img = null;
        if(isset($_FILES['no_fluo_img'])){
            if(is_uploaded_file($_FILES['no_fluo_img']['tmp_name'])){
                $no_fluo_img = base64_encode(file_get_contents(addslashes($_FILES['no_fluo_img']['tmp_name'])));
            }
        }
        else{
            $no_fluo_img = null;
        }
        

        $no_halog = null;
        if(empty($_POST['no_halog']) && !isset($_POST['no_halog'])){
            $no_halog = 0;
        }else{
            $no_halog = intval($_POST['no_halog']);
        }
        $no_halog_img = null;
        if(isset($_FILES['no_halog_img'])){
            if(is_uploaded_file($_FILES['no_halog_img']['tmp_name'])){
                $no_halog_img = base64_encode(file_get_contents(addslashes($_FILES['no_halog_img']['tmp_name'])));
            }
        }
        else{
            $no_halog_img = null;
        }
        $total_in_watt = null;
        if(empty($_POST['total_in_watt']) && !isset($_POST['total_in_watt'])){
            $total_in_watt = 0;
        }else{
            $total_in_watt = floatval($_POST['total_in_watt']);
        }

        $total_in_watt_img = null;
        if(isset($_FILES['total_in_watt_img'])){
            if(is_uploaded_file($_FILES['total_in_watt_img']['tmp_name']) || file_exists($_FILES['total_in_watt_img']['tmp_name'])){
                $total_in_watt_img = base64_encode(file_get_contents(addslashes($_FILES['total_in_watt_img']['tmp_name'])));
            }
        }
        else{
            $total_in_watt_img = null;
        }
        $total_in_light = $_POST['total_in_light'];

        $total_out_watt = null;
        if(empty($_POST['total_out_watt'])){
            $total_out_watt = 0;
        }else{
            $total_out_watt = intval($_POST['total_out_watt']);
        }
        $total_out_watt_img;
        if(isset($_FILES['total_in_watt_img'])){
            if(is_uploaded_file($_FILES['total_out_watt_img']['tmp_name'])){
                $total_out_watt_img = base64_encode(file_get_contents(addslashes($_FILES['total_out_watt_img']['tmp_name'])));
            }
        }
        else{
            $total_out_watt_img = null;
        }
        $watt_sensor = null;
        if(empty($_POST['watt_sensor'])){
            $watt_sensor = 0;
        }else{
            $watt_sensor = intval($_POST['watt_sensor']);
        }
        
        $watt_sensor_img = null;
        if(isset($_FILES['total_in_watt_img'])){
            if(is_uploaded_file($_FILES['watt_sensor_img']['tmp_name'])){
                $watt_sensor_img = base64_encode(file_get_contents(addslashes($_FILES['watt_sensor_img']['tmp_name'])));
            }
        }
        else{
            $watt_sensor_img = null;
        }
        $total_out_light = floatval($_POST['total_out_light']);
        $light_inspect = trim($_POST['light_inspect']);
        $light_points = floatval($_POST['light_points']);
        $asstcomment = "";
        if(empty($_POST['asstcomment'])){
            $asstcomment = "";
        }else{
            $asstcomment = $_POST['asstcomment'];
        }

        $prop_id = trim($_POST['prop_id']);

        $userid = intval($_POST['userid']);
        $daylightid = intval($_POST['daylightid']);

        $updatequery = "update daylightlighting set lux_meter=?, no_led=?,
        no_led_img=?,no_fluo=?,lux_meter=?,no_halog=?,no_halog_img=?,total_in_watt=?,
        total_in_watt_img=?,total_in_light=?,total_out_watt=?,total_out_watt_img=?,
        watt_sensor=?,watt_sensor_img=?, total_out_light=?,light_inspect=?,light_points=?, 
        asstcomment=? where prop_id=? and userid=? and daylightid=?";

        $stmt = mysqli_prepare($con, $updatequery);
        mysqli_stmt_bind_param($stmt,"sibibibdbdibibisissii", $lux_meter, $no_led,$no_led_img,$no_fluo,$no_fluo_img,
        $no_halog, $no_halog_img, $total_in_watt, $total_in_watt_img, $total_in_light, $total_out_watt, $total_out_watt_img,
        $watt_sensor, $watt_sensor_img, $total_out_light, $light_inspect, $light_points, $asstcomment, $prop_id, $userid, $daylightid);
        mysqli_stmt_send_long_data($stmt, 2, $no_led_img);
        mysqli_stmt_send_long_data($stmt, 4, $no_fluo_img);
        mysqli_stmt_send_long_data($stmt, 6, $no_halog_img);
        if($total_in_watt_img != null){
            mysqli_stmt_send_long_data($stmt, 8, $total_in_watt_img);
        }
        mysqli_stmt_send_long_data($stmt, 11, $total_out_watt_img);
        mysqli_stmt_send_long_data($stmt, 13, $watt_sensor_img);
        $result = mysqli_stmt_execute($stmt);
        if($result){
            $json['error'] = false;
            $json['message'] = "Updated daylight Successfully!";
        }else{
            $json['error'] = true;
            $json['message'] = "Updated daylight failed! ". mysqli_error($con);
        }
    }else{
        $json['error'] = true;
        $json['message'] = "No permission to access!";

    }
    echo json_encode($json);
    mysqli_close($con);

    function ifdaylightexist(){
        
    }

    function ifdaylightadded(){
        
    }

?>
