<?php
function cmsminwages() { 
?>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<div class="container">
  <form action="" method="post" id="form" name="form">  
    <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                  <select class="custom-select" name="cmscategory" id="cmscat" required="required">
                    <option value="">Select Category</option>
                    <option <?php echo ((isset($_POST['cmscategory']) && $_POST['cmscategory'] == "Shop & Establishment") ? "selected" : "")?> value="Shop & Establishment">Shop & Establishment</option>
                    <option <?php echo ((isset($_POST['cmscategory']) && $_POST['cmscategory'] == "Factory") ? "selected" : "")?> value="Factory">Factory</option>
                    <option <?php echo ((isset($_POST['cmscategory']) && $_POST['cmscategory'] == "Hotel & Restaurants") ? "selected" : "")?> value="Hotel & Restaurants">Hotel & Restaurants</option>
                    <option <?php echo ((isset($_POST['cmscategory']) && $_POST['cmscategory'] == "Agriculture") ? "selected" : "")?> value="Agriculture">Agriculture</option>
                  </select>
              </div>
            </div>
            <div class="col-md-3">
                 <div class="form-group">
                    <input type="text" name="cmsdate" class="form-control" value="<?php if(isset($_POST['cmsdate'])){echo $_POST['cmsdate'];} ?>" id="icmsdate" placeholder="dd-mm-yyyy" required="required" autocomplete="off">
                  </div>
            </div>

            <div class="col-md-3">
                  <button type="submit" name="btncmssubmit" class="btn btn-primary">Submit</button>
            </div>
    </div>

</form>
<?php
if (isset($_POST['btncmssubmit'])) {
  $cate = $_POST["cmscategory"];
  $date = $_POST["cmsdate"];
  $inputDate =  date('Y-m-d', strtotime($date)); 
  global $wpdb;
  $query__ = "SELECT DISTINCT * FROM `{$wpdb->prefix}minw_cms` WHERE `tdate` >= '$inputDate' AND `fdate` <= '$inputDate' AND `cat` = '$cate'";
  $query__run = $wpdb->get_results($query__);
      if(!empty($query__run)){
        $sortState_ = [];
        foreach ($query__run as $key_ => $value_) {
            $state_ = $value_->state;
            array_push($sortState_, $state_);
          }
    
      sort($sortState_);
      foreach($sortState_ as $key => $statename)
      {
        ?>
            <button class="btn btn-primary stlist" onclick="getNoti(this.value)" value="<?php echo $statename ?>" name="<?php echo $statename ?>"><?php echo $statename; ?></button>
           <?php
      }
      }
      else{
        echo '<div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 class="alert-heading">Warning!</h4>
        <p class="mb-0">Notification that you are looking for is not available now so we are displaying the closest notification to the given date.</p>
      </div>';

      $query_2 = "SELECT DISTINCT `state` FROM `{$wpdb->prefix}minw_cms` WHERE  `cat` = '$cate' ";
      $query__run2 = $wpdb->get_results($query_2);    
          if($query__run2){
            $sortState_2 = [];
            foreach ($query__run2 as $key_2 => $value_2) {
              $state_2 = $value_2->state;
              array_push($sortState_2, $state_2);
            }
            sort($sortState_2);
            foreach($sortState_2 as $key => $statename2)
            {
              ?>
                  <button class="btn btn-primary stlist" value="<?php echo $statename2 ?>" name="<?php echo $statename2 ?>"><?php echo $statename2; ?></button>
                 <?php
            }
          }
    }
}
?>
<div id="show"></div>
</div>
<?php
}   
add_shortcode('CMSMINW', 'cmsminwages');
add_action( 'hook-cmsminwages', 'cmsminwages');