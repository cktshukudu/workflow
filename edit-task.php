<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Task Edit</title>
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
$task_id = $_GET['task_id'];

if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
}

$page_name="Edit Task";
include("includes/sidebar.php");

$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

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
 

if(isset($_POST['update_task_info'])){
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
          <br>Please log in <a href='	https://workflow.herokuapp.com/' target='_blank'>here</a> 
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

<!--modal dialog for editing tasks-->

<div class="row">
	<div class="col-md-12">
	<div class="well well-custom">
		<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="well">
			<h3 class="text-center" style="font-weight: bold; font-size: 30px;">Edit Task </h3>
				<hr style="border: 5px solid #33b5e5;"><br>
					<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
						<div class="form-group">
							<label class="control-label col-sm-5">Task Title</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control" value="<?php echo $row['t_title']; ?>" <?php if($user_role != 1){ ?> readonly <?php } ?> val required>
							</div>
							</div>
							<div class="form-group">
							<label class="control-label col-sm-5">Task Description</label>
							<div class="col-sm-7">
								<textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="5" cols="5"><?php echo $row['t_description']; ?></textarea>
							</div>
							</div>
							<div class="form-group">
							<label class="control-label col-sm-5">Start Time</label>
							<div class="col-sm-7">
								<input type="text" name="t_start_time" id="t_start_time"  class="form-control" value="<?php echo $row['t_start_time']; ?>">
							</div>
							</div>
							<div class="form-group">
							<label class="control-label col-sm-5">End Time</label>
							<div class="col-sm-7">
								<input type="text" name="t_end_time" id="t_end_time" class="form-control" value="<?php echo $row['t_end_time']; ?>">
							</div>
							</div>

							<div class="form-group">
							<label class="control-label col-sm-5">Assign To</label>
							<div class="col-sm-7">
								<?php 
								$sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
								$info = $obj_admin->manage_all_info($sql);   
								?>
								<select class="form-control" name="assign_to" id="aassign_to" <?php if($user_role != 1){ ?> disabled="true" <?php } ?>>
								<option value="">Select</option>

								<?php while($rows = $info->fetch(PDO::FETCH_ASSOC)){ ?>
								<option value="<?php echo $rows['user_id']; ?>" <?php
									if($rows['user_id'] == $row['t_user_id']){
									?> selected <?php } ?>><?php echo $rows['fullname']; ?></option>
								<?php } ?>
								</select>
							</div>
							</div>

                      		<div class="form-group">
                    			<label class="control-label col-sm-5">Email</label>
                    		<div class="col-sm-7">
                      			<input type="text" name="t_email" placeholder="Enter Notifying Email" id="t_email"  class="form-control" <?php if($user_role != 1){ ?> readonly <?php } ?> val required>
                    		</div>
                  			</div>

							<div class="form-group">
							<label class="control-label col-sm-5">Status</label>
							<div class="col-sm-7">
								<select class="form-control" name="status" id="status">
								<option value="0" <?php if($row['status'] == 0){ ?>selected <?php } ?>>Incomplete</option>
								<option value="1" <?php if($row['status'] == 1){ ?>selected <?php } ?>>In Progress</option>
								<option value="2" <?php if($row['status'] == 2){ ?>selected <?php } ?>>Completed</option>
								</select>
							</div>
							</div>
						
						<div class="form-group">
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-3">
							</div>
							<div class="col-sm-3">
							<button type="submit" name="update_task_info" id="update_task_info" class="btn btn-success-custom">Update Now</button>
							</div>
						</div>
						</form> 
					</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

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

</body>
</html>


