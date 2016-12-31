<?php
session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";
$bill_id=$_GET["id"];

?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="text-center">
              VIEW REPORT DETAILS
              
            </h3>
        </div>
        </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/user/add.php");?>

   
    <!--include helper class-->

    <?php require_once("$root/lib/classes/class.helper.php");?>
    
    <div class="row">
        <div class="col-sm-12">
        <form action="#" method="POST">

            <!-- Table -->
       <div class="box">
      
       
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped" id="bill_content_table">

                    <tr>
                      
                      <th>Test</th>
                      <th>Subtest</th>
                      <th>Default value</th>
                      <th>Result</th>
                      <th>Unit</th>
                    </tr>
                    
                    <?php
                        
                       $Contents=new Helper();
                       $bill_contents=$Contents->getBillContents($bill_id);

                       if(empty($bill_contents))
                       {
                        ?>
                          <td>There is no content for this report</td>
                        <?php
                       }
                       else
                       {

                          foreach($bill_contents as $single_bill_content)
                          {

                            $single_test=$Contents->getSingleTest($single_bill_content['test_id']);


                            $single_subtest=$Contents->getSingleSubTest($single_bill_content['subtest_id']);

                            if(empty($single_test)||empty($single_subtest))
                              {
                                ?>
                                  <tr>
                                  <td>There is error. please dont prcoess this report</td>
                                  </tr>

                                <?php
                              }
                              else
                              {
                            ?>
                              <tr>
                                <td><?php echo $single_test[0]['name'];?></td>
                                <td><?php echo $single_subtest[0]['name'];?></td>
                                <td><?php echo $single_subtest[0]['default_value'];?></td>
                                <?php


                                  $single_report_data=$Contents->getSingleReportContent($bill_id,$single_bill_content['id']);
                                ?>
                                <td><input type="text"  value="<?php echo $single_report_data[0]['result'];?>" disabled></td>
                                <td><?php echo $single_subtest[0]['unit'];?></td>
                              </tr>

                            <?php
                              }
                          }
                       }

                    ?>
                    
                   
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
           
              </form>
        </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>