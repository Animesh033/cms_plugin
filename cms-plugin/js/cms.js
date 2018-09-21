jQuery(document).ready( function($){
   $('.stlist').click(function(){
      var statename = this.value;
      var cate = $("#cmscat").val();
      var indate = $("#icmsdate").val();
      var inputDate = indate.split("-").reverse().join("-");
      // alert(statename);
  
    //Some event will trigger the ajax call, you can push whatever data to the server, simply passing it to the "data" object in ajax call
    $.ajax({
      url: ajax_object.ajaxurl, // this is the object instantiated in wp_localize_script function
      type: 'POST',
      data:{ 
        action: 'myaction', // this is the function in your functions.php that will be triggered
        category:cate,
        date:inputDate,
        state:statename
      },
      success: function( data ){
        //Do something with the result from server
        // console.log( data );
        $('#show').html(data);
      }
    });
  });
/** End of the above function*/
      // alert(statename);
  
    //Some event will trigger the ajax call, you can push whatever data to the server, simply passing it to the "data" object in ajax call
    

/**Date picker*/ 
$('#icmsdate').datepicker({
            dateFormat: "dd-mm-yy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            orientation: "button",
            maxDate: 0,
            yearRange: "1970: ",
          });

$('#fdatepicker , #tdatepicker').datepicker({
            dateFormat: "dd-mm-yy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            orientation: "button",
            maxDate: 0,
            yearRange: "1970: ",
            onSelect: function(){

              var insfdate = $('#fdatepicker').val();
              var instdate = $('#tdatepicker').val();
              var instate = $('#insertstate').val();
              var inscate = $('#insertcate').val();
              $.ajax({
                url: ajax_object2.ajaxurl, // this is the object instantiated in wp_localize_script function
                type: 'POST',
                data:{ 
                  action: 'myaction2',
                  checkfdate:insfdate,  // this is the function in your functions.php that will be triggered
                  checktdate:instdate,
                  checkstate:instate,
                  checkcategory:inscate
                },
                success: function(response){
                  //Do something with the result from server
                  // console.log(response);
                  if(response == 'fd'){
                    // $('#insertedfd').html('<p style="color:red;"><b>This date is already exists!</b></p>');
                  }
                  else{
                    // $('#insertedtd').style.display = 'none';
                  }
                }
              });
            }
          });
});