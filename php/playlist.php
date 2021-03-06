<?php
  // Create connection
  $con = mysqli_connect("localhost","djfeed","password","djlogs");

  // Check connection
  if (mysqli_connect_errno()){
    echo "{\"error\":\"".mysqli_connect_error()."\"}";
    die();
  }

  if(!$_POST[day] | !$_POST[month] | !$_POST[year]){
    $sql = "SELECT * FROM djlogs WHERE ts > CURDATE() ORDER BY id DESC";
  }else{
    $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT);
    $month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT);
    $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM djlogs WHERE ts BETWEEN '".$year."/".$month."/".$day."' AND '".$year."/".$month."/".strval(intval($day) + 1)."' ORDER BY id DESC";
  }



  // Execute query
  if ($result = mysqli_query($con,$sql))
  {
    $rows = array();
    //success
    while($assoc = mysqli_fetch_assoc($result)){
      array_push($rows, $assoc);
    }

    echo json_encode($rows);
  }
  else
  {
    echo "Error parsing data: " . mysqli_error($con);
  }

  mysqli_close($con);
?>
