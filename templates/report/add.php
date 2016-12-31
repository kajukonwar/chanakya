<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";


?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

<!--include helper class-->

<?php require_once("$root/lib/classes/class.helper.php");?>


<!--Process submission-->

<?php require_once("$root/lib/classes/class.helper.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="text-center">
        Add new test
        
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/inventory/add.php");?>

  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Add patient details</a></li>
              <li><a href="#tab_2" data-toggle="tab">Add referer doctor</a></li>

              <li><a href="#tab_3" data-toggle="tab">Add Test reports</a></li>

            </ul>

  <form class="form-horizontal" name="edit_user_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="tab-content">

     <div class="tab-pane active" id="tab_1">

    <!--patient details-->


           <div class="form-group">
              <label class="control-label col-sm-3" for="patient_name">Patient's full name</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="patient_name" id="patient_name" aria-describedby="patient_name">

                 </div>

           </div>

           <div class="form-group">
              <label class="control-label col-sm-3" for="patient_address">Address</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <textarea class="form-control" name="patient_address" id="patient_address" aria-describedby="patient_name"></textarea>

                 </div>

           </div>


           <div class="form-group">
              <label class="control-label col-sm-3" for="patient_address">Contact number</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="patient_contact" id="patient_contact" aria-describedby="patient_contact">

                 </div>

           </div>


           <div class="form-group">
              <label class="control-label col-sm-3" for="patient_email">Email</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="email" class="form-control" name="patient_email" id="patient_email" aria-describedby="patient_email">

                 </div>

           </div>

           <div class="form-group">
              <label class="control-label col-sm-3" for="patient_email">Gender</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                      <div class="radio">
                        <label><input type="radio" name="patient_gender" value="male">Male</label>
                      </div>
                      <div class="radio">
                        <label><input type="radio" name="patient_gender" value="female">Female</label>
                      </div>

                 </div>

           </div>

           <div class="form-group">
              <label class="control-label col-sm-3" for="patient_age">Age</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="patient_age" id="patient_age" aria-describedby="patient_age">
                 </div>

           </div>

        
      </div><!--end tab patient details-->

       <div class="tab-pane" id="tab_2"><!-- doctor details-->


       
        <div class="form-group">
              <label for="sel1">Select Referer Docotor:</label>
                <select class="form-control" name="doctor_name" id="doctor_name">

                  <option value="0" selected>Click to choose a doctor</option>
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

        

      </div><!--end tab doctors details-->
    

       <div class="tab-pane" id="tab_3"><!-- test report entry-->


       
        <div class="form-group">
              <label for="sel1">Select the test:</label>
                <select class="form-control" name="test_name" id="test_name">

                  <option value="0" selected>Click to choose a Test</option>
                <?php 
                   $tests=new Helper();
                   $available_tests=$tests->getTest();

                   foreach($available_tests as $single_test)
                   {



                ?>

                  <option value="<?php echo $single_test['id'];?>"><?php echo $single_test['name'];?></option>
                <?php
                  }
                ?>
                </select>

        </div>

        <div class="form-group">
              <label for="sel1">Select the Subtest:</label>
                <select class="form-control" name="subtest_name" id="subtest_name">

                  <option value="0" selected>Click to choose a subtest</option>
                <?php 
                   $subtests=new Helper();
                   $available_subtests=$subtests->getSubTest();

                   foreach($available_subtests as $single_subtest)
                   {



                ?>

                  <option value="<?php echo $single_subtest['id'];?>"><?php echo $single_subtest['name'];?></option>
                <?php
                  }
                ?>
                </select>

        </div>

         <div class="form-group">
              <label for="sel1">Enter the result</label>
                <input type="text" class="form-control" name="test_result" id="test_result">


        </div>
        

      </div><!--end test report entry-->

    </div><!--end tab content-->
  
  
            <button type="submit" name="save_report" class="btn btn-primary">Save</button>
            <button class="btn btn-danger" type="reset">Reset</button>
  </form>
  </div>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>