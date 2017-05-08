<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
if($permission!="admin")
{
  die("Unauthorized access");
}
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

<?php require_once("$root/lib/classes/class.helper.php");?>

<?php 

   $transaction=new Helper();
   
   //$today="2016-11-15";
   $today=date('Y-m-d');

   $transaction_today=$transaction->get_transaction_day($today);


   //$transaction_overall=$transaction->get_all_transaction();

   ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
     
    </section>

    <!-- Main content -->
    <section class="content">

     
       <hr>
      <div class="row">
        <div class="col-lg-6 col-xs-6">


          <div class="small-box bg-aqua">

         <h4 class="text-center"><strong>Transaction Today</strong></h4>

            <div class="inner">
              <h4> Rs <?php echo $transaction_today;?></h4>

              
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
              &nbsp;
            </a>
          </div>
        </div>

        <div class="col-lg-6 col-xs-6">


          <div class="small-box bg-aqua">

            <h4 class="text-center"><strong>Transaction Overall</strong></h4>
            <div class="inner">
              <h4>Rs <?php //echo $transaction_overall;?></h4>

            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
              From 11 November,2016 
            </a>
          </div>
        </div>
        
      </div>  <!--end row-->

      <hr>

      <div class="row">
         <div class="col-sm-12">
           <form id="transaction_search_form">
            <div class="form-group" style="margin-left:20px;">
              <div class="form-group">
                <h4 class="text-center">Get transaction for a day:</h4>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="transaction_search_date" id="transaction_search_date">
                </div>
               
              </div>

            </div>
            </form>

            <p class="text-center" style="color:red;display:none;" id="transaction_search_error">Please select a date</p>


            <button id="get_transaction_on_day" class="btn btn-lg btn-primary  center-block">Get it</button>

          </div>

          <div class="col-sm-12" id="transaction_on_day" style="display:none;">
                  <div class="row">

                        <div class="col-sm-2">
                        </div>

                       <div class="col-sm-8">
                            <div class="small-box bg-aqua">

                         <h3 class="text-center"></h3>

                            <div class="inner" >

                              <h4 class="text-center" id="transaction_on_day_text"><strong></strong></h4>
                              <h4 id="transaction_on_day_amount" class="text-center"></h4>

                              
                            </div>
                            <div class="icon">
                              <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                              &nbsp;
                            </a>
                          </div>
                        </div>
                        
                        <div class="col-sm-2">
                        </div>
                  </div>
          </div>

      </div>
    
    
    
    </section>
    <!-- Main content -->
  </div>
 
  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>