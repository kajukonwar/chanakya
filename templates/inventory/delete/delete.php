<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

<?php 
    require_once("$root/lib/classes/class.inventory.php");

    if(isset($_GET['test_id']))
    {
      $delete=new Test();
      
      $delete_test=$delete->delete($_GET['test_id']);


    }

    if(isset($_GET['subtest_id']))
    {
      $delete=new Subtest();
      $delete_subtest=$delete->delete($_GET['subtest_id']);
    }

     require_once("$root/lib/classes/class.helper.php");

      $list_tests=new Helper();
      $list_of_tests=$list_tests->getTest();
      $list_of_subtests=$list_tests->getSubTest();
      
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="text-center">
              DELETE INVENTORY
              
            </h3>
        </div>
      </div>

    <div class="callout callout-success">
             
          <p>
          <?php 

          if(isset($delete_test)&&$delete_test=="success") echo "The test was deleted successfully";

          if(isset($delete_test)&&$delete_test=="error") echo "There was error. Test could not be deleted";


          if(isset($delete_subtest)&&$delete_subtest=="success") echo "The Subtest was deleted successfully";

          if(isset($delete_subtest)&&$delete_subtest=="error") echo "There was error. Subtest could not be deleted";





          ?>
          </p>   

     </div>
     
      <div class="row">
      <div class="col-sm-12">
      <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#test" data-toggle="tab">Delete tests</a></li>
                            <li><a href="#subtest" data-toggle="tab">Delete subtests</a></li>
                           
                           
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
                  <th>Delete</th>
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
                  <td><a href="http://localhost/chanakya/chanakya/templates/inventory/delete/delete.php?test_id=<?php echo $single_test['id'];?>" role="button">Delete</a>
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
                  <th>Delete</th>
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
                  <th>added date</th>
                  <th>Delete</th>
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
                  <td><a href="http://localhost/chanakya/chanakya/templates/inventory/delete/delete.php?subtest_id=<?php echo $single_subtest['id'];?>" role="button">Delete</a>
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
                  <th>added date</th>
                  <th>Delete</th>
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

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>