<?php
add_action( "wp_ajax_myaction", "so_wp_ajax_function" );
add_action( "wp_ajax_nopriv_myaction", "so_wp_ajax_function" );
function so_wp_ajax_function(){
  $cate = $_POST["category"];
  $date = $_POST["date"];
  $state = $_POST["state"];
  global $wpdb;
  $query = "SELECT DISTINCT * FROM `{$wpdb->prefix}minw_cms` WHERE `tdate` >= '$date' AND `fdate` <= '$date' AND `cat` = '$cate' AND `state` = '$state' ";
  $query_run = $wpdb->get_results($query);
  $path_array  = wp_upload_dir();
  $path = str_replace('\\', '/', $path_array['baseurl']);
  if(!empty($query_run)){
    foreach ($query_run as $key => $value) {
      ?>
      <table border="1" style="width:100%;table-layout:fixed">
                   <tr>
                      <td>  
                        <?php echo $value->code ?>
                      </td>
                      <!-- <td>  
                        <a target="_blank" href="<?php echo $path."/notifications/".$value->notifile  ?>">View file</a>
                      </td> -->
                   </tr>
               </table>
      <?php
    }
  }
  else{
    $query2 = "SELECT DISTINCT * FROM `{$wpdb->prefix}minw_cms` WHERE  `cat` = '$cate' AND `state` = '$state' ";
    $query_run2 = $wpdb->get_results($query2);
    if(!empty($query_run2)){
          $dateArray = [];
          foreach ($query_run2 as $key2 => $value2) {
            $datafdate = $value2->fdate;
            array_push($dateArray, $datafdate);
          }
          $min = find_closest($dateArray, $date);
          $query3 = "SELECT * FROM `{$wpdb->prefix}minw_cms` WHERE `cat` = '$cate' AND `fdate` = '$min' AND `state` = '$state' ";
          $query_run3 = $wpdb->get_results($query3);
          if(!empty($query_run3)){
            foreach ($query_run3 as $key3 => $value3) {
            ?>
              <table border="1" style="width:100%;table-layout:fixed">
                   <tr>
                      <td>  
                        <?php echo $value3->code ?>
                      </td>
                      <!-- <td>  
                        <a target="_blank" href="<?php echo $value3->path ?>">View file</a>
                      </td> -->
                   </tr>
               </table>
            <?php
            } 
          }
          else{
            echo 'Notification not found!';
          }
    }
  }
  wp_die(); // ajax call must die to avoid trailing 0 in your response
}

function find_closest($array, $date)
{
    foreach($array as $day)
    {
        $interval[] = abs(strtotime($date) - strtotime($day));
    }
    asort($interval);
    $closest = key($interval);
    return $array[$closest];
}

/** Second ajax call to strict uploading same notification*/
add_action( "wp_ajax_myaction2", "so_wp_ajax_function2" );
add_action( "wp_ajax_nopriv_myaction2", "so_wp_ajax_function2" );
function so_wp_ajax_function2(){
  $checkfdate = date('Y-m-d', strtotime($_POST['checkfdate'])) ;
  $checktdate = date('Y-m-d', strtotime($_POST['checktdate'])) ;
  $checkstate = $_POST['checkstate'];
  $checkcategory = $_POST['checkcategory'];
  global $wpdb;
  $queryFdate = "SELECT * FROM `{$wpdb->prefix}minw_cms` WHERE `fdate` = '$checkfdate' ";
  $queryFdateRun = $wpdb->get_results($queryFdate);
  if(!empty($queryFdateRun))
    echo 'fd';
  else
    echo "td";
  wp_die(); // ajax call must die to avoid trailing 0 in your response
}
?>