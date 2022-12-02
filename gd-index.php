<?php

// Include configuration file

include_once 'config.php';

$status = $statusMsg = '';
if(!empty($_SESSION['status_response'])){
    $status_response = $_SESSION['status_response'];
    $status = $status_response['status'];
    $statusMsg = $status_response['status_msg'];
    
    unset($_SESSION['status_response']);
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files</title>
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
    input[type=file]::file-selector-button {
        border: 1.5px solid #4091d7;
        padding: .3em .5em;
        position: relative;
        background-color: #4091d7;
        font-size: .9em;
        font-weight: bold;
        color: #fff;
        transition: .5s;
        cursor: pointer;

        top: 0;
        height: 50px;
        margin-top: -10px;
        margin-left: -15px;
    }
    input[type=file]::file-selector-button:hover {
        background-color: #4778b3;
        border: 1.5px solid #4778b3;
        color: azure;
    }
</style>

<?php

// require 'authentication.php';

// authentication check

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// admininstrator check

$user_role = $_SESSION['user_role'];

$page_name="Edit Task";
include("includes/sidebar.php");

?>

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="well">
            <h3 class="text-center" style="font-weight: bold; font-size: 30px;">UPLOAD FILE TO GOOGLE DRIVE</h3>
            <hr style="border: 5px solid #33b5e5;"><br>
            <div class="row">
              <div class="col-md-12">
                
                <!-- Status message -->

                <?php if(!empty($statusMsg)){ ?>
                    <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
                <?php } ?>

                <form class="form-horizontal" role="form" action="upload.php" method="post" autocomplete="off" enctype="multipart/form-data">
                  <div class="form-group">
                      <label class="control-label col-sm-4">File Name</label>
                      <div class="col-sm-6">
                            <input type="file" name="file" class="form-control input-custom">
                      </div>
                  </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-3">
                            <input type="submit" class="btn btn-success-custom" name="submit" value="Upload"/>
                      </div>
                      <div class="col-sm-3">
                          <a title="Update Task"  href="task-info.php"><span class="btn btn-danger-custom btn-xs">Back</span></a>
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- JS start & end times -->

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