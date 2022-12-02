<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management</title>
  <link rel="icon" href="assets/img/icon.jpg">
	<link rel="stylesheet" href="assets/css/loading.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<style>
  body {
		background: linear-gradient(#00b16a, rgba(0, 0, 0, 0.5), #33b5e5), url(assets/img/banner.jpg) !important;
		background-size: cover !important;
		backdrop-filter: blur(5px) !important;
	}
  h3 {
    font-weight: bold !important;
  }
</style>
  
<?php

require 'authentication.php'; 

// authentication check

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// admininstrator check

$user_role = $_SESSION['user_role'];

if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}

$page_name="Task_Info";
include("includes/sidebar.php");

?>

<?php

// Import PHPMailer classes into the global namespace

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception; 
 
// Include library files 

require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 

$massage = '';
 

if(isset($_POST['add_task_post'])){
	$email = $_POST['t_email'];
	// $status = $_POST['status'];

// Create an instance; Pass `true` to enable exceptions 
$mail = new PHPMailer(); 
 
// **************Server settings***************** //

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output 

$mail->isSMTP();                                   // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;                            // Enable SMTP authentication 
$mail->Username = 'devtecspac@gmail.com';       // SMTP username 
$mail->Password = 'nijexjqbulxjtbnz';              // SMTP password 
$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587 ;                                // TCP port to connect to 
 
// Sender info 

$mail->setFrom('devtecspac@gmail.com', 'admin'); 
$mail->addReplyTo('reply@example.com', 'admin');
 
// Add a recipient 

$mail->addAddress($email); //$mail->addCC('cc@example.com'); --AND/OR-- $mail->addBCC('bcc@example.com'); 
$mail->isHTML(true); // Set email format to HTML 
$mail->Subject = 'TASK NOTIFICATION ALERT !!'; // Mail subject 
 
// Mail body content 

$sql = "SELECT task_id, t_email, t_end_time FROM task_info
        ORDER BY task_id";

      $info = $obj_admin->manage_all_info($sql);

      while($row = $info->fetch(PDO::FETCH_ASSOC)){

        $t_email = $row["t_email"];
        $end_time = $row["t_end_time"];

        date_default_timezone_set('Africa/Johannesburg');
        $date = date('Y-m-d H:i:s');

        if ($t_email == true) {

          $bodyContent = "<p>Hi there,<br><br>A new task has been added and it is <strong>DUE</strong> @<strong>$end_time</strong>.
          <br>Please log in <a href='https://workflow-application.herokuapp.com/index.php' target='_blank'>here</a> 
          and make approriate changes to this reference.<br><br>Regards.</p>"; 
          $bodyContent .= "<p>This email is sent by the <b>Admin</b></p>"; 
          $mail->Body   = $bodyContent; 
        } 

        // if ($date >= $end_time) {

        //   $bodyContent = "<p>Hi there,<br><br>Your task is <strong>OVERDUE</strong>.
        //   <br>Please log in <a href='https://workflow-application.herokuapp.com/index.php' target='_blank'>here</a> 
        //   and make approriate changes to this reference.<br><br>Regards.</p>"; 
        //   $bodyContent .= "<p>This email is sent by the <b>Admin</b></p>"; 
        //   $mail->Body   = $bodyContent; 
        // }
      }  

// Send email 

if(!$mail->send()) { 
    $massage = 'Notification NOT sent !!'; 
} else { 
    $massage = 'Notification sent !!'; 
}

//closing stmp connection

$mail->smtpClose();
}

?>

<!-- task information -->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog add-category-modal">
  
<!-- Modal dialog for new task assignment -->

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title text-center" style="font-weight: bold;">Assign New Task</h2>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form role="form" action="" method="post" autocomplete="off">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-5">Task Title</label>
                  <div class="col-sm-7">
                    <input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control" id="default" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Task Description</label>
                  <div class="col-sm-7">
                    <textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="5" cols="5"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Start Time</label>
                  <div class="col-sm-7">
                    <input type="text" name="t_start_time" id="t_start_time" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">End Time</label>
                  <div class="col-sm-7">
                    <input type="text" name="t_end_time" id="t_end_time" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Assign To</label>
                  <div class="col-sm-7">
                    <?php 
                      $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                      $info = $obj_admin->manage_all_info($sql);   
                    ?>
                    <select class="form-control" name="assign_to" id="aassign_to" required>
                      <option value="">Select User...</option>

                      <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                      <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Email</label>
                <div class="col-sm-7">
                  <input type="text" name="t_email" placeholder="Enter Notifying Email" id="t_email" list="expense" id="default" class="form-control" <?php if($user_role != 1){ ?> readonly <?php } ?> val required>
                  </div>
                </div>
                <div class="form-group">
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" name="add_task_post" id="add_task_post" class="btn btn-success-custom">Assign Task</button>
                  </div>
                  <div class="col-sm-3">
                    <button type="submit" class="btn btn-danger-custom" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </form> 
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- task management section -->

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <div class="gap"></div>
      <div class="row">
        <div class="col-md-8">
          <div class="btn-group">
            <?php if($user_role == 1){ ?>
            <div class="btn-group">
              <button class="btn btn-primary btn-menu" data-toggle="modal" data-target="#myModal" style="border: 0; border-radius: 5px;">Assign New Task</button>
            </div>
          <?php } ?>

          </div>
        </div>
      </div>
      <center><h3>Task Management Section</h3></center>
      <br>
      <div class="gap"></div>
      <div class="gap"></div>

      <div class="table-responsive">
        <table class="table">
          <thead class="thead-dark">
            <tr scope="col" style="color: #fff; background: #292b2c;">
              <th>#</th>
              <th>Task Title</th>
              <th>Assigned To</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Action</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          <?php 
            if($user_role == 1){
              $sql = "SELECT a.*, b.fullname, b.email 
                    FROM task_info a
                    INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                    ORDER BY a.task_id DESC";
            }else{
              $sql = "SELECT a.*, b.fullname, b.email 
              FROM task_info a
              INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
              WHERE a.t_user_id = $user_id
              ORDER BY a.task_id DESC";
            } 
            
              $info = $obj_admin->manage_all_info($sql);
              $serial  = 1;
              $num_row = $info->rowCount();
              if($num_row==0){
                echo '<tr><td colspan="7">No Data found</td></tr>';
              }
                  while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
          ?>
            <tr>
              <td><?php echo $serial; $serial++; ?></td>
              <td><?php echo $row['t_title']; ?></td>
              <td><?php echo $row['fullname']; ?></td>
              <td><?php echo $row['t_start_time']; ?></td>
              <td><?php echo $row['t_end_time']; ?></td>
              <td>
                <?php  if($row['status'] == 1){
                    echo "In Progress <span style='color:#d4ab3a;' class=' glyphicon glyphicon-refresh' >";
                }elseif($row['status'] == 2){
                    echo "Completed <span style='color:#00af16;' class=' glyphicon glyphicon-ok' >";
                }else{
                  echo "Incomplete <span style='color:#d00909;' class=' glyphicon glyphicon-remove' >";
                } ?>
              </td>
              <td>
           
                <a title="View Task" href="task-details.php?task_id=<?php echo $row['task_id']; ?>"><span class="glyphicon glyphicon-folder-open"></span></a>&nbsp;&nbsp;
              <?php if($user_role == 2){ ?>
                <a title="Upload Document"  href="gd-index.php"><span class="glyphicon glyphicon-upload"></span></a>&nbsp;&nbsp;
              <?php } ?>
              <?php if($user_role == 1){ ?>
                <!-- <a title="Notification"  href="email-notification.php"><span class="glyphicon glyphicon-bell"></span></a>&nbsp;&nbsp; -->
                <a title="Update Task"  href="edit-task.php?task_id=<?php echo $row['task_id'];?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                <a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td>
            <?php } ?>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php

include("includes/footer.php");

?>

<!-- loader wrapper --> 

<div class="loader-wrapper">
	<span class="loader loader-gradient-green"><span class="loader-inner"></span></span>
</div>

<script>
	$(window).on("load", function() {
		$(".loader-wrapper").fadeOut("slow");
	});
</script>

<!-- JS start & end times -->

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true
  });

  flatpickr('#t_end_time', {
    enableTime: true
  });

</script>

</body>
</html>



