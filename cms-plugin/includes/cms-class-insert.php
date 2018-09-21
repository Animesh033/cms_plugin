<?php
function custom_form() {
 ?>
 <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
   <div class="">
    <div class="cms__container">
    
      <div class="cms__content">
        <h2>Upload Minimum wage notifications</h2>
 <form action ="<?php echo $_SERVER['REQUEST_URI']; ?>" method ="post" enctype="multipart/form-data">
        <ul class="form-list" style="list-style: none;">
            <li class="form-list__row">
              <label>Name</label>
              <input type="text" name="name" required="" autocomplete="off" />
            </li>
             <li class="form-list__row">
              <label>Select State</label>
                <select name="state" id="insertstate">
                    <option value="Andhra">Andhra</option>
                    <option value="Arunachal">Arunachal</option>
                    <option value="Assam">Assam</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Chandigarh">Chandigarh</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Gujrat">Gujrat</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Maharastra">Maharastra</option>
                    <option value="Manipur">Manipur</option>
                    <option value="Meghalaya">Meghalaya</option>
                    <option value="Mizoram">Mizoram</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="Nagaland">Nagaland</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Sikkam">Sikkam</option>
                    <option value="Tamilnadu">Tamilnadu</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="West Bengal">West Bengal</option>
                </select>
            </li>
            <li class="form-list__row">
              <label>Select Category</label>
                <select name="cat" id="insertcate">
                    <option value="Shop & Establishment">Shop & Establishment</option>
                  <option value="Factory">Factory</option>
                  <option value="Agriculture">Agriculture</option>
                  <option value="Hotel & Restaurants">Hotel & Restaurants</option>
                </select>
            </li>
            <li class="form-list__row">
              <!-- <label>From Date</label> -->
              <div id="insertedfd"></div>
              <input type="text" name="fdate" required="" id="fdatepicker"autocomplete="off"  />
              <div id="error"></div>
            </li>
               <li class="form-list__row">
              <label>To Date</label>
              <!-- <div id="insertedtd"></div> -->
              <input type="text" name="tdate" required="" id="tdatepicker"autocomplete="off"  />
            </li>
           
              
               <li class="form-list__row">
              <label>Upload PDF file</label>
              <input type="file" name="notifile" required="" />
            </li>

              <!--  <li class="form-list__row">
              <label>Upload Code</label>
            <input type="file" onchange="loadfile(this)" name="code" />
            </li> -->
             <li class="form-list__row">
            <textarea id="text" cols="72" rows="10" name="code" placeholder="Paste html code here "></textarea>   
             </li>
            <li>
              <button type="submit" name="submit" class="button" value="upload">Upload</button>
            </li>
          </ul>
 </form>
 </div> <!-- END: .modal__content -->
      
    </div> <!-- END: .modal__container -->
  </div> <!-- END: .modal -->
<script type="text/javascript">
  function loadfile(input){
    var reader = new FileReader();
    reader.onload = function(e){
        document.getElementById('text').value = e.target.result;
    }
    reader.readAsText(input.files[0]);
}</script>
 <?php
}
add_shortcode('display', 'custom_form');
if($_POST['submit']) {
 global $wpdb;
 $table_name ='wp_minw_cms';
 $name = $_POST['name'];
 $fdate = date('Y-m-d', strtotime($_POST['fdate']));
 $tdate = date('Y-m-d', strtotime($_POST['tdate']));
 $state = $_POST['state'];
 $cat = $_POST['cat'];
 $nfile = $_FILES['notifile']['name'];
 $tempnfile = $_FILES['notifile']['tmp_name'];
 $code = $_POST['code'];

 $qury = "SELECT * FROM `{$wpdb->prefix}minw_cms` WHERE ('$fdate' BETWEEN `fdate` AND `tdate`) OR ('$tdate' BETWEEN `fdate` AND `tdate`) HAVING `state` = '$state' AND `cat` = '$cat' ";
 $Qrun = $wpdb->get_results($qury);
 if(empty($Qrun)){
  $path_array  = wp_upload_dir();
// print_r($path_array);
$path = str_replace('\\', '/', $path_array['basedir']);
$target_path_sia = uniqid().$nfile ; //uniqid().$nfile will give you unique file name

$dirname = "/notifications/";
$filename = $path.$dirname;

if (!file_exists($filename)) {
    mkdir($path.$dirname, 0644);
    // echo "The directory $dirname was successfully created.";
    // exit;
} else {
    // echo "The directory $dirname exists.";
}

$moved = move_uploaded_file($tempnfile,$path . $dirname . $target_path_sia);
// echo "Stored in: " . $path. $dirname .$target_path_sia;

$filepath = $path_array['baseurl'].$dirname.$target_path_sia;
 $success = $wpdb->insert("wp_minw_cms", array(
   "name" => $name,
   "fdate" => $fdate,
   "tdate" => $tdate,
   "state" => $state,
   "cat" => $cat,
   "notifile" => $target_path_sia,
   "code" => $code,
   "path" => $filepath
));
 if($success) {
 // echo ' Inserted successfully';
    echo '<script>alert("Notification inserted successfully!")</script>';
    header("refresh:0 ; url = http://localhost/wordpress/cuncovered/page-k/");
    exit;
      } else {
   // echo 'Not inserted!';
   }

   if($moved) {
 // echo ' Moved successfully';
      } else {
   // echo 'Not moved';
   }
 }
 else{
  echo '<script>alert("Notification for this date already exists!");</script>';
  header("refresh:0 ; url = http://localhost/wordpress/cuncovered/page-k/");
  exit;
 }
}
?>