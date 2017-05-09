<!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Created by Kaju
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy;<?php echo date("Y");?>  <a href="#">Chanakya diagnostics</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/app.min.js"></script>


<script src="/plugins/daterangepicker/moment.js"></script>

<script src="/plugins/daterangepicker/daterangepicker.js"></script>


<!-- bootstrap datepicker -->
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>

<script src="/plugins/vex-master/dist/js/vex.combined.js"></script>
<script>vex.defaultOptions.className='vex-theme-os'</script>

<!--ck editor-->
<script src="/plugins/ckeditor/ckeditor.js"></script>
<script>
//replace textarea with ckeditor instance
CKEDITOR.replace('special_bill_editor',{
    toolbar: 'CustomToolbar'
    
});
</script>

<!--special bill print-->
<script>
  CKEDITOR.replace('special_bill_pdf',{
    toolbar: 'CustomToolbar'
    
});

  $("#special_bill_print_button").on("click",function()
  {

    var editor=CKEDITOR.instances.special_bill_pdf;
    editor.execCommand('print');
  });
</script>

<script>
//Replace the special bill contents textarea
CKEDITOR.replace('bill_view_special_content');
</script>


<script>
//Replace the special report fill textarea
CKEDITOR.replace('special_report_editor',{
    toolbar: 'CustomToolbar'
    
});
</script>

<script>
//Replace the special report print textarea
CKEDITOR.replace('specil_report_print',{
    toolbar: 'CustomToolbar'
    
});
</script>

<script>

$("#special_report_print_button").on("click",function()
{

  var editor1=CKEDITOR.instances.specil_report_print;
  editor1.execCommand("print");
})
</script>

<script>
//special bill view details
CKEDITOR.replace('bill_view_special_content',{
    toolbar: 'CustomToolbar'
    
});
</script>

<script>
//Special report update textarea
CKEDITOR.replace('special_report_content',{
    toolbar: 'CustomToolbar'
    
});
</script>

<script>
//Special report content view
CKEDITOR.replace('special_report_content_view',{
    toolbar: 'CustomToolbar'
    
});
</script>



<script>
$("#test").click(function()

{
  

});

$("#test1").click(function()

{

vex.dialog.alert('Error: Report could not be saved.')

});


$("#test2").click(function()

{

  
vex.dialog.alert('Error: An unexpected error occured')

});



</script>




<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
     

<script>

 $("#bill_test_name").on('change', function() {

    //get the bill id 
    var data=$("#bill_test_name option:selected").val();

    
    if(data==0)
    {
       $('#bill_subtest_name').html(' ');
      
      $('#bill_subtest_name').prop("disabled", true); // Element(s) are now enabled.


      $('#bill_cost').val("");
      
      $('#bill_cost').prop("disabled", true); // Element(s) are now enabled.
    }
   
    else
    {

   $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: { 'test_data': data },
   
    success: function(result){
       var result=JSON.parse(result);
       
       $('#bill_subtest_name').html('');
       $('#bill_subtest_name').append('<option value="0">Please choose a subtest</option>');
       
       $.each(result, function( key, value ) {
        
        $('#bill_subtest_name').append('<option value='+value.id+'>'+value.name+'</option>');
        
      }

     );

    }
   });
   
   
   $('#bill_subtest_name').prop("disabled", false); // Element(s) are now enabled.
   $('#bill_cost').val("");     
   $('#bill_cost').prop("disabled", true); // Element(s) are now enabled.
    }

  
});


$("#bill_subtest_name").on('change', function() {

    var data=$("#bill_subtest_name option:selected" ).val();

    if(data==0)
    {
      $('#bill_cost').val("");
      
      $('#bill_cost').prop("disabled", true); // Element(s) are now disabled.
    }
   
    else
    {
       $.ajax({
        type: "POST",
        url: "http://chanakya.lab/lib/ajax.php",
        data: { 'subtest_data': data },
       
        success: function(result){
           var result=JSON.parse(result);
           
           $('#bill_cost').val(result.standard_price);
           $('#bill_cost').prop("readonly", true);
           

        }
       });
       
       
       $('#bill_cost').prop("disabled", false); // Element(s) are now enabled.

  }
  
});



$("#add_bill_item").on('click', function() {

    var test_id=$("#bill_test_name option:selected").val();

    var test_name=$("#bill_test_name option:selected").html();



    var subtest_id=$("#bill_subtest_name option:selected" ).val();


    var subtest_name=$("#bill_subtest_name option:selected" ).html();

    var cost= $('#bill_cost').val();

    var index= $('#bill_item_index').val();

    var count= $('#bill_item_count').val();


    
    //show error message

    if(test_id==0)
    {

      $("#bill_test_name_err").html("Please choose a test to add");

    }
    else
    {

      $("#bill_test_name_err").html("");

         if(subtest_id==0)
      {
        $("#bill_subtest_name_err").html("Please choose a subtest to add");
      }
      else
      {
        $("#bill_subtest_name_err").html("");

          if(!$.trim(cost)||$.trim(cost)==0)
        {
          $("#bill_cost_err").html("There should be a valid cost for tests and subtests");
        }
        else
        {
              $("#bill_cost_err").html("");

               $('#add_bill_item').prop("disabled", true); // Element(s) are now enabled.

              var data_index = parseInt(index) + 1;
             // var new_count = parseInt(count) + 1;


              var bill_data={ 'index':data_index,'bill_test_id': test_id,'bill_subtest_id':subtest_id,'bill_unit_cost':cost };

              $.ajax({
              type: "POST",
              url: "http://chanakya.lab/lib/ajax.php",
              data: {bill_content_data:bill_data},
             
              success: function(result){
                 
                      
                        var current_bill_count=JSON.parse(result);

                        

                        $.ajax({
                        type: "POST",
                        url: "http://chanakya.lab/lib/ajax.php",
                        data: {get_department_id:subtest_id},
                       
                        success: function(result){

                          var result=JSON.parse(result);
                           
                          $('#bill_content_table').append('<tr class="bill_content_row"><td>'+test_name+'</td><td>'+subtest_name+'</td><td>'+result+'</td><td>'+cost+'</td><td><button type="button" class="remove_bill_row btn-danger" value="'+data_index+'">Remove</button></td></tr>');

                        $('#bill_item_index').val(data_index);
                        //$('#bill_item_count').val(new_count);

                           $('#add_bill_item').prop("disabled", false); // Element(s) are now enabled.


                        }
                       });

                       
                 

              }
             });





              
              
        }
      }
    }
  
  
});


$(document).on('click', '.remove_bill_row', function(){ 
     // Your Code
    var trow=$(this).closest("tr");

    var index=$(this).val();
    
     $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {remove_data:index},
   
    success: function(result){
        trow.remove();

        //var new_content_count=JSON.parse(result);
       

    }
   });

   

  

});





$('input[type=radio][name=doctor_refer]').change(function() {

   if(this.value=="yes")
   {
    $("#bill_doctor_name").show();
    //show doctor name select dropdown for special/different format bill
    $("#special_bill_doctor_name").show();
   }
   else
   {
    $("#bill_doctor_name").hide();
    //hide doctor name select dropdown for special/different format bill
    $("#special_bill_doctor_name").hide();
   }

});


$('#save_bill').on('click',function() {


//$('#save_bill').prop("disabled", true); // Element(s) are now enabled.

document.getElementById("save_bill").disabled = true;

var doctor_data=$("#add_bill_doctor").serialize();


var patient_data=$("#add_bill_patient").serialize();


var data=doctor_data+"&"+patient_data;

$.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {save_bill_data:data},
   
    success: function(result){
       
      var status=JSON.parse(result);

      switch(status.patient_name)
      {

        case 1:
          $("#patient_name_err").html("Please enter the patient name");
          break;

        case 2:
          $("#patient_name_err").html("Patient name should contain only letters and whitespace");
          break;

        default:

          $("#patient_name_err").html("");

      }

      switch(status.patient_contact)
      {

        case 1:
          $("#patient_contact_err").html("");
          break;

        case 2:
          $("#patient_contact_err").html("Contact number should be 10 digits long");
          break;

        default:

          $("#patient_contact_err").html("");

      }

       switch(status.patient_age)
      {

        case 1:
          $("#patient_age_err").html("Please enter the age");
          break;

        case 2:
          $("#patient_age_err").html("Patient age should be 1-3 digit long");
          break;

        default:

          $("#patient_age_err").html("");

      }

       switch(status.patient_gender)
      {

        case 1:
          $("#patient_gender_err").html("Please select the patient's gender");
          break;

        case 2:
          $("#patient_gender_err").html("");
          break;

        default:

          $("#patient_gender_err").html("");

      }

       switch(status.patient_email)
      {

        case 1:
          $("#patient_email_err").html("");
          break;

        case 2:
          $("#patient_email_err").html("Invalid email format");
          break;

        default:

          $("#patient_email_err").html("");

      }

      switch(status.doctor_refer)
      {

        case 1:
          $("#doctor_refer_err").html("Please select this option");
          break;

        case 2:
          $("#doctor_refer_err").html("");
          break;

        default:

          $("#doctor_refer_err").html("");

      }

      if(status.doctor_refer==0)
      {

          switch(status.bill_doctor_name)
        {

          case 1:
            $("#bill_doctor_name_err").html("Please select the doctor name");
            break;

          case 2:
            $("#bill_doctor_name_err").html("");
            break;

          default:

            $("#bill_doctor_name_err").html("");

        }
      }
        switch(status.bill_contents)
        {

          case 1:
            $("#bill_contents_err").html("You have not added any bill contents");
            break;

          case 2:
            $("#bill_contents_err").html("");
            break;

          default:

            $("#bill_contents_err").html("");

        }


        if(status.patient_name==0&&status.patient_contact==0&&status.patient_age==0&&status.patient_gender==0&&status.patient_email==0&&status.doctor_refer==0&&status.bill_contents==0&&status.save_error==0)
        {

          if(status.bill_doctor_name==0)
          {

            //get the new bill no.
                 var new_bill_id=parseInt(status.current_bill_id)+1;

                  if(new_bill_id!=0)
                  {
                    var new_bill_text="Bill no. "+new_bill_id;
                    $("#bill_no").html(new_bill_text);
                  }
                  else
                  {
                    $("#bill_no").html("");
                  }
                  

             
            //reset the forms
            document.getElementById("add_bill_patient").reset();

            $("#bill_doctor_name").hide();

            document.getElementById("add_bill_doctor").reset();

            //reset the index counter and item counter


            $("#bill_item_count").val("0");

            $("#bill_item_index").val("0");

            //remove the bill contents

            $("tr").remove(".bill_content_row");

            //reset the select tests form

            
            document.getElementById("add_bill_form").reset();


            $('#bill_subtest_name').html(' ');
      
            $('#bill_subtest_name').prop("disabled", true); // Element(s) are now enabled.     

            var print_bill_url="http://chanakya.lab/lib/pdf/bill.php?b_id="+status.current_bill_id;
            window.open(print_bill_url,'_blank');
          }
        }
      
      
      //$('#save_bill').prop("disabled", false); // Element(s) are now enabled.


      document.getElementById("save_bill").disabled = false;

    }
    
   });
      



});

//fill and save pending report
$('#report_save').on('click',function() {

    var data=$("#report_edit_form").serialize();

    $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {save_report_data:data},
   
    success: function(result){
       
         var result=JSON.parse(result);
        console.log(result[0]);
        console.log(result[1]);


        switch(result[0])
        {
          case "success":

          var query="http://chanakya.lab/templates/report/status.php?status=success&r_id="+result[1];
          window.location.href=query;
          break;

          case "partial":

          var query="http://chanakya.lab/templates/report/status.php?status=partial&r_id="+result[1];
          window.location.href=query;
          break;

          case "error":

          var query="http://chanakya.lab/templates/report/status.php?status=error1&r_id="+result[1];
          window.location.href=query;
          break;

          default:

          var query="http://chanakya.lab/templates/report/status.php?status=error2&r_id=0";
          window.location.href=query;

        }

      
       
      
    }
   });

});



//print saved report

$('#report_print').on('click',function() {

    var r_id=$("#report_id").val();
    var query="http://chanakya.lab/lib/pdf/report.php?r_id="+r_id;
    window.open(query,'_blank');
   

});


//send report email

$('#report_send_email').on('click',function() {

    var data=$("#report_save_status_form").serialize();

    $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/classes/class.send_mail.php",
    data: {send_report_email:data},
   
    success: function(result){
       
         var result=JSON.parse(result);

         if(result=="success")
         {
            vex.dialog.alert('Email has been sent successfully')
         }
         else
         {
            
            vex.dialog.alert('Error: Email could not be sent')
         }
       
       
      
    }
   });

});

//send email to doctor

$('#report_send_email_doctor').on('click',function() {

    var data=$("#report_save_status_form").serialize();

    $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/classes/class.send_mail.php",
    data: {send_report_email_doctor:data},
   
    success: function(result){
       
         var result=JSON.parse(result);

         if(result=="success")
         {
            vex.dialog.alert('Email has been sent successfully')
         }
         else
         {
            
            vex.dialog.alert('Error: Email could not be sent')
         }
       
       
      
    }
   });

});

//send SMS

$('#report_send_sms').on('click',function() {

    var data=$("#report_save_status_form").serialize();

    $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/classes/class.send_sms.php",
    data: {send_report_sms:data},
   
    success: function(result){
       
         //var result=JSON.parse(result);

         
            vex.dialog.alert(result)
        
 
      
    }
   });

});


//go back to view reports after saving

$('#report_go_back').on('click',function() {

   window.location.href="http://chanakya.lab/templates/report/report.php"; 

});

//update completed report
$('#report_update').on('click',function() {

    var data=$("#report_update_form").serialize();

    $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {update_report_data:data},
   
    success: function(result){
       
       var result=JSON.parse(result);
       if(result[0]=="success")
       {

        
        vex.dialog.buttons.YES.text="View the details"
        vex.dialog.buttons.NO.text="View other reports"
        vex.dialog.confirm({

            message: 'The report has been updated successsfully.',
            callback: function(value)
            {

              if(value)
              {
                var query="http://chanakya.lab/templates/report/viewDetails.php?id="+result[1];
                window.location.href=query;
              }
              else
              {
                var query="http://chanakya.lab/templates/report/view.php?status=all";
                window.location.href=query;
              }
            }



        })

        
       }
       else
       {
        
       }

    }
   });

});

//date range picker for bill search

//show department when test entry is being done

/*
$('input[type=radio][name=test_has_subtest]').change(function() {

   if(this.value=="yes")
   {
    $("#test_department_name").show();
   }

   if(this.value=="no")
   {

    $("#test_department_name").hide();
   }

   

});
*/

//bill search
$("#bill_search_button").on('click',function(){

var data=$("#bill_search_form").serialize();

$.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {bill_search:data},
  
    success: function(result){
  
      var result=JSON.parse(result);
      console.log(result);

      if(result=="error")
      {
        $("#bill_search_error").show();
      }
      else if(result=="empty")
      {
        $("#bill_search_error").hide();
        $('#bill_content_table').html("");
        $('#bill_content_table').append('<tr><th>ID</th><th>Patient name</th><th>Date</th><th>Status</th><th></th><th></th></tr>');

        $('#bill_content_table').append('<tr><td>No results found</td></tr>');
      }
      else
      {

          $("#bill_search_error").hide();
          $('#bill_content_table').html("");
          $('#bill_content_table').append('<tr><th>ID</th><th>Patient name</th><th>Date</th><th>Status</th><th></th><th></th></tr>');

           $.each(result, function( key, value ) {
        
               $('#bill_content_table').append('<tr><td>'+value.id+'</td><td>'+value.patient_name+'</td><td>'+value.created_on+'</td><td>'+value.status+'</td><td><a href="http://chanakya.lab/templates/bill/viewdetails.php?id='+value.id+'" class="btn btn-primary" role="button">View Details</a></td><td><a href="http://chanakya.lab/lib/pdf/bill.php?b_id='+value.id+'" target="_blank" class="btn btn-primary" role="button">Print</a></td></tr>');
          })
      }
     

    }
   });



})//end bill search


//total doctor reference search
$("#d_reference_search_button").on('click',function(){

var data=$("#d_reference_form").serialize();




$.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {d_reference_search:data},
  
    success: function(result){
  
      var result=JSON.parse(result);
     

      
      if(result=="error")
      {
        $("#d_reference_search_error").show();

        $('#d_reference_total_value').html("");
        $('#d_reference_total_value').hide();
        $('#d_reference_bill_content_table').html("");

      }
      else if(result=="empty")
      {
        $("#d_reference_search_error").hide();
        $('#d_reference_bill_content_table').html("");

        $('#d_reference_total_value').html("");
        $('#d_reference_total_value').hide();

        $('#d_reference_bill_content_table').append('<tr><th>ID</th><th>Date</th><th>Status</th></tr>');

        $('#d_reference_bill_content_table').append('<tr><td>No results found</td></tr>');
      }
      else
      {

          $("#d_reference_search_error").hide();

          $('#d_reference_total_value').html("");
          $('#d_reference_total_value').append(' <h3>Total References: Rs. '+result.total_value+'</h3>');
          $('#d_reference_total_value').show();

          $('#d_reference_bill_content_table').html("");
          $('#d_reference_bill_content_table').append('<tr><th>ID</th><th>Date</th><th>Status</th></tr>');

           $.each(result.bills, function( key, value ) {
        
              
              
               $('#d_reference_bill_content_table').append('<tr><td>'+value.id+'</td>'+'<td>'+value.created_on+'</td><td>'+value.status+'</td></tr>');
               
          })
      }
      
     

    }
   });



})//end total doctor reference search


    $("#bill_search_date").daterangepicker({

      locale:{

        format:'YYYY/MM/DD'
      }
   
    });

    //total doctor reference search date
    $("#d_reference_search_date").daterangepicker({

      locale:{

        format:'YYYY/MM/DD'
      }
   
    });


  //transaction search date

    $('#transaction_search_date').datepicker({

      autoclose: true
    });


    //search transaction with ajax
    $("#get_transaction_on_day").on('click',function(){

    var transaction_search_data=$("#transaction_search_form").serialize();

    $.ajax({
        type: "POST",
        url: "http://chanakya.lab/lib/ajax.php",
        data: {transaction_search:transaction_search_data},
      
        success: function(result){
      
        var result=JSON.parse(result);
        if(result!="error")
        {
          $("#transaction_on_day_text").html("Transaction on the chosen date");

          $("#transaction_on_day_amount").html("Rs "+result);

         $("#transaction_on_day").show();

         $("#transaction_search_error").hide();
        }
        else
        {

          $("#transaction_on_day").hide();
          $("#transaction_search_error").show();

        }
      }

       });
      



    })

  
//report search
$("#report_search_button").on('click',function(){

var data=$("#report_search_form").serialize();

$.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/ajax.php",
    data: {report_search:data},
  
    success: function(result){
  
      var result=JSON.parse(result);
      console.log(result);

      if(result=="error")
      {
        $("#report_search_error").show();
      }
      else if(result=="empty")
      {
        $("#report_search_error").hide();
        $('#report_content_table').html("");
        $('#report_content_table').append('<tr><th>ID</th><th>Patient name</th><th>Date</th><th>Status</th><th></th><th></th></tr>');

        $('#report_content_table').append('<tr><td>No results found</td></tr>');
      }
      else
      {

          $("#report_search_error").hide();
          $('#report_content_table').html("");
          $('#report_content_table').append('<tr><th>ID</th><th>Patient name</th><th>Date</th><th>Status</th><th></th><th></th><th></th></tr>');

           $.each(result, function( key, value ) {
        

               if(value.status=="pending")
               {

               //$('#report_content_table').append('<tr><td>'+value.id+'</td><td>'+value.patient_name+'</td><td>'+value.created_on+'</td><td>'+value.status+'</td>');

               $('#report_content_table').append('<tr><td>'+value.id+'</td><td>'+value.patient_name+'</td><td>'+value.created_on+'</td><td>'+value.status+'</td><td><a href="http://chanakya.lab/templates/report/fill.php?id='+value.id+'" class="btn btn-primary" role="button">Fill Report</a></td></tr>');
               }
               else if(value.status=="complete")
               {


               //$('#report_content_table').append('<tr><td>'+value.id+'</td><td>'+value.patient_name+'</td><td>'+value.created_on+'</td><td>'+value.status+'</td>');
               $('#report_content_table').append('<tr><td>'+value.id+'</td><td>'+value.patient_name+'</td><td>'+value.created_on+'</td><td>'+value.status+'</td><td><a href="http://chanakya.lab/templates/report/update.php?id='+value.id+'" class="btn btn-primary" role="button">Update Report</a></td><td><a href="http://chanakya.lab/templates/report/viewDetails.php?id='+value.id+'" class="btn btn-primary" role="button">View Details</a></td><td><a href="http://chanakya.lab/lib/pdf/report.php?r_id='+value.id+'"  target="_blank" class="btn btn-primary" role="button">Print report</a></td></tr>');

               }
               else
               {

                $('#report_content_table').append('<td>Error! Something went wrong.</a></td></tr>');


               }

              
          })
      }
     

    }
   });



})
   


    $("#report_search_date").daterangepicker({

      locale:{

        format:'YYYY/MM/DD'
      }
   
    });


    //send SMS to the owner at the end of day

    $('#send_sms_owner').on('click',function() {

    var data="send_sms_owner";// it has no meaning, just to fill in the data field of ajax call
    $.ajax({
    type: "POST",
    url: "http://chanakya.lab/lib/classes/class.send_sms.php",
    data: {send_sms_owner:data},
   
    success: function(result){
       
         //var result=JSON.parse(result);

         
            vex.dialog.alert(result)
        
 
      
    }
   });

});
</script>