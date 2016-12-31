<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 <?php require_once("$root/lib/classes/class.helper.php");

      $list_doctors=new Helper();
      $list_of_doctors=$list_doctors->getDoctors();
      

 ?>

    <section class="content-header">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="text-center">
              VIEW DOCTOR
              
            </h3>
        </div>
      </div>
     
      <div class="row">
      <div class="col-sm-12">
      <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                       <h4 class="text-center">Available doctors in Chanakya diagnostics</h4>
                </div>
                <div class="panel-body">
                  
                        
                          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl. no.</th>
                  <th>Doctor name</th>
                  <th>Designation</th>
                  <th>Hospital</th>
                  <th>added date</th>
                  <th>View details</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($list_of_doctors))
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
                  foreach($list_of_doctors as $single_doctor)
                  {
                  ?>
                  <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $single_doctor['full_name'];?></td>
                  <td><?php echo $single_doctor['designation'];?>
                  </td>
                  <td><?php echo $single_doctor['hospital'];?>
                  </td>
                  <td><?php echo $single_doctor['date_created'];?>
                  </td>
                  <td><a href="http://localhost/chanakya/chanakya/templates/doctor/edit/editDetails.php?d_id=<?php echo $single_doctor['id'];?>" role="button">View details</a>
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
                  <th>Doctor name</th>
                  <th>Designation</th>
                  <th>Hospital</th>
                  <th>added date</th>
                  <th>View details</th>
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
  
    </section>

  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>
          