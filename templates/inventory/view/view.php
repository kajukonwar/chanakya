<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 <?php require_once("$root/lib/classes/class.helper.php");

      $list_tests=new Helper();
      $list_of_tests=$list_tests->getTest();
      $list_of_subtests=$list_tests->getSubTest();

 ?>

    <section class="content-header">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="text-center">
              VIEW INVENTORY
              
            </h3>
        </div>
      </div>
     
      <div class="row">
      <div class="col-sm-12">
      <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active" style="margin-left:330px;"><a href="#test" data-toggle="tab" class="btn-info">View tests</a></li>
                            <li style="margin-left:30px;"><a href="#subtest" data-toggle="tab" class="btn-info">View subtests</a></li>
                           
                           
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="test">
                          <div class="box">
            <div class="box-header">
              <h3 class="text-center">Available tests in Chanakya diagnostics</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl. no.</th>
                  <th>Test name</th>
                  <th>added date</th>
                  <th>View Details</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($list_of_tests))
                {

                  ?>
                  <tr>
                  <td>Sorry, no tests found in record</td>
                  </tr>

                  <?php
                }
                else
                {
                  $i=1;
                  foreach($list_of_tests as $single_test)
                  {
                  ?>
                  <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $single_test['name'];?></td>
                  <td><?php echo $single_test['date_created'];?>
                  </td>
                  <td><a href="http://chanakya.lab/templates/inventory/edit/test.php?test_id=<?php echo $single_test['id'];?>" role="button" class="btn btn-primary">View Details</a>
                  </td>                  
                  </tr> 


                  <?php
                  $i++;
                  }
                }
                ?>
                
             </tbody>
                <tfoot>
                <tr>
                  <th>Sl. no.</th>
                  <th>Test name</th>
                  <th>added date</th>
                  <th>View Details</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>

                        </div>
                        <div class="tab-pane fade" id="subtest">
                          
                          <div class="box">
            <div class="box-header">
              <h3 class="text-center">Available subtests in Chanakya diagnostics</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl. no.</th>
                  <th>Subtest name</th>
                  <th>Related test</th>
                  <th>Unit</th>
                  <th>Default value</th>
                  <th>Standard price</th>
                  <th>Added date</th>
                  <th>View Details</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($list_of_subtests))
                {

                  ?>
                  <tr>
                  <td>Sorry, no tests found in record</td>
                  </tr>

                  <?php
                }
                else
                {
                  $i=1;
                  foreach($list_of_subtests as $single_subtest)

                  {

                     $related_test=$list_tests->getSingleTest($single_subtest['test_id']);

                  ?>
                  <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $single_subtest['name'];?></td>
                  <td><?php echo $related_test[0]['name'];?></td>
                  <td><?php echo $single_subtest['unit'];?></td>
                  <td><?php echo $single_subtest['default_value'];?></td>
                  <td><?php echo $single_subtest['standard_price'];?></td>
                  <td><?php echo $single_subtest['date_created'];?>
                  </td>
                  <td><a href="http://chanakya.lab/templates/inventory/edit/subtest.php?subtest_id=<?php echo $single_subtest['id'];?>" role="button" class="btn btn-primary">View Details</a>
                  </td>                  
                  </tr> 


                  <?php
                  $i++;
                  }
                }
                ?>
                
             </tbody>
                <tfoot>
                <tr>
                  <th>Sl. no.</th>
                  <th>Subtest name</th>
                  <th>Related test</th>
                  <th>Unit</th>
                  <th>Default value</th>
                  <th>Standard price</th>
                  <th>Added date</th>
                  <th>View Details</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>

                        </div>
                        
                    </div>
                </div>
            </div>
      </div>
      </div>
  
    </section>

  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>
          