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

      $list_staff=new Helper();
      $list_of_staff=$list_staff->getStaff();
      

 ?>

    <section class="content-header">

     <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="text-center">
              EDIT STAFF
              
            </h3>
        </div>
      </div>
     
      <div class="row">
      <div class="col-sm-12">
      <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                       <h4 class="text-center">Available staff in Chanakya diagnostics</h4>
                </div>
                <div class="panel-body">
                  
                        
                          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl. no.</th>
                  <th>Full  name</th>
                  <th>User name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Role</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(empty($list_of_staff))
                {

                  ?>
                  <tr>
                  <td>Sorry, no records found</td>
                  </tr>

                  <?php
                }
                else
                {
                  $i=1;
                  foreach($list_of_staff as $single_staff)
                  {
                  ?>
                  <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $single_staff['full_name'];?></td>
                  <td><?php echo $single_staff['user_name'];?>
                  </td>
                  <td><?php echo $single_staff['email'];?>
                  </td>
                  <td><?php echo $single_staff['contact'];?>
                  </td>
                  <td><?php echo $single_staff['role'];?>
                  </td>
                  <td><a href="http://localhost/chanakya/chanakya/templates/user/edit/editDetails.php?s_id=<?php echo $single_staff['id'];?>" role="button">Edit details</a>
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
                  <th>Full  name</th>
                  <th>User name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Role</th>
                  <th>Edit</th>
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
          