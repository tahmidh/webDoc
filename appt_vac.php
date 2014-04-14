<?php 
    require("common.php"); 
     
    if(empty($_SESSION['user'])) 
    { 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     
    if(!empty($_POST)) 
    {  
         $query = " 
            INSERT INTO appointment ( 
                appt_name, 
                time, 
                date, 
                detail,
                user_id,
                appt_for
            ) VALUES ( 
                :appt_name, 
                :time, 
                :date, 
                :detail,
                :user_id,
                :appt_for
            ) 
        "; 
          $query_params = array( 
            ':appt_name' => $_POST['appt_name'],  
            ':time' => $_POST['time'],
            ':date' => $_POST['date'],
            ':detail' => $_POST['detail'],
            ':user_id' => $_SESSION['user']['id'],
            ':appt_for' => "vaccine"
        ); 
         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>WebDoc - Better Health, Better Life</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="text-muted">WebDoc</h3>
        <ul class="nav nav-justified">
          <li ><a href="user.php">Home</a></li>
          <li class="active" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Get Appointment<b class="caret"></b></a>
            <ul class="dropdown-menu">
             <li><a href="view_appt.php">View your Appointment</a></li>
              <li class="divider"></li>
              <li><a href="appt_vac.php">Appointment for Vaccination</a></li>
              <li class="divider"></li>
              <li><a href="appt_doc.php">Appointment for Doctor</a></li>
            </ul>
          </li> <!-- drop down list for vaccination / doctor -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">User Profile<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="view_profile.php">View Profile</a></li>
              <li class="divider"></li>
              <li><a href="edit_profile.php">Edit Profile</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Diagnostics-Report<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Upload Report</a></li>
              <li class="divider"></li>
              <li><a href="#">Review Report</a></li>
              <li class="divider"></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
              <li class="divider"></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="edit_account.php">Edit Account</a></li>
              <li><a href="logout.php">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>

     <form class="form-horizontal" action="appt_vac.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Create Appointment for Vaccination </legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="appt_name">Appt. Name</label>  
  <div class="col-md-4">
  <input id="appt_name" name="appt_name" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="time">Time</label>  
  <div class="col-md-4">
  <input id="time" name="time" type="text" placeholder="e.g 11:12:30" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="date">Date</label>  
  <div class="col-md-4">
  <input id="date" name="date" type="text" placeholder="2014-04-15" class="form-control input-md">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="detail">Detail</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="detail" name="detail"></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-info">submit</button>
  </div>
</div>

</fieldset>
</form>

      <!-- Site footer -->
      <div class="footer">
        <p>&copy; Company 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
