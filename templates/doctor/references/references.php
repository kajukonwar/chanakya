<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
if($permission=="admin"||$permission=="reception")
{

}
else
{
  die("Unauthorized access");
}


?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
   
      
    </section>

    <!-- Main content -->
    <section class="content">

   

   
    <!--include helper class-->

    <?php require_once("$root/lib/classes/class.helper.php");?>
    
    
    <div class="row text-center">
    <div class="col-sm-12">
     
    <form  id="d_reference_form" class="form-inline">

     <div class="form-group" id="d_reference_doctor_id">
            <label class="control-label"  for="d_reference_doctor_id">Doctor name</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-user-md" aria-hidden="true"></i></span>
              <select class="form-control" name="d_reference_doctor_id">
              <option value="0" selected>Click to select Doctor</option>
                <?php 
                   $doctors=new Helper();
                   $available_doctors=$doctors->getDoctors();

                   foreach($available_doctors as $single_doctor)
                   {



                ?>

                  <option value="<?php echo $single_doctor['id'];?>"><?php echo $single_doctor['full_name'];?></option>
                <?php
                  }
                ?>
            
              </select>
            </div>
           
    </div>
    
    
              <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="d_reference_search_date" id="d_reference_search_date">
                </div>
               
              </div>
    

    <div class="col-sm12">
    <div class="form-group" style="margin-top:30px;">
            <label class="control-label"></label>
           <div class="input-group">
            <button type="button" name="d_reference_search_button" id="d_reference_search_button" class="btn btn-primary btn-lg">Search</button>
            </div>

    </div>
    </div>
    </form>
   
  </div>
  <div class="col-sm-12">

  <h4 id="d_reference_search_error" class="text-center" style="color:red;display:none;"><br><br>Please select both Doctor name and date range</h4>
  </div>
  </div>

 <hr>
  
    <div class="row">

        <div class="col-sm-12">

        <div id="d_reference_total_value" class="alert alert-success" role="alert" style="display:none;">
          
         
          
        </div>
        </div>
        <div class="col-sm-12">
            <!-- Table -->
       <div class="box">
      
                
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped" id="d_reference_bill_content_table">

                    <tr>
                      
                      <th>ID</th>                    
                      <th>Date</th>
                      <th>Status</th>
                                       
                    </tr>
               
        
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
        </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>