<?php 
    require("common.php"); 
     
    if(empty($_SESSION['user'])) 
    { 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     
    if(!empty($_POST)) 
    {  
          
        if(!empty($_POST['name']))
        { 

        // Initial query parameter values 
        $query_params = array( 
            ':name' => $_POST['name'], 
            ':user_id' => $_SESSION['user']['id'], 
        );  
        
        $query = " 
            UPDATE users 
            SET 
                name = :name 
        "; 
        $query .= " 
            WHERE 
                id = :user_id 
        "; 
         
        try 
        { 
            // Execute the query 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        {  
            die("Failed to run query: " . $ex->getMessage()); 
        }
      }
        $query = " 
            UPDATE users
            SET
                age = :age, 
                ssn = :ssn, 
                blood_gp = :blood_gp, 
                dob = :dob,
                contact = :contact
           "; 
        $query .= " 
            WHERE 
                id = :user_id 
        "; 
          $query_params = array( 
            ':age' => $_POST['age'],  
            ':ssn' => $_POST['ssn'],
            ':blood_gp' => $_POST['blood'],
            ':dob' => $_POST['dob'],
            ':contact' => $_POST['contact'],
            ':user_id' => $_SESSION['user']['id'], 
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
          <li  ><a href="user.php">Home</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Get Appointment<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="view_appt.php">View your Appointment</a></li>
              <li class="divider"></li>
              <li><a href="appt_vac.php">Appointment for Vaccination</a></li>
              <li class="divider"></li>
              <li><a href="appt_doc.php">Appointment for Doctor</a></li>
            </ul>
          </li> <!-- drop down list for vaccination / doctor -->
          <li class="active" class="dropdown">
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
          <li  class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="edit_account.php">Edit Account</a></li>
              <li><a href="logout.php">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
<form class="form-horizontal" action="edit_profile.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Edit Profile</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name</label>  
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder=""  class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="age">Age</label>  
  <div class="col-md-4">
  <input id="age" name="age" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="ssn">SSN</label>  
  <div class="col-md-4">
  <input id="ssn" name="ssn" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="blood">Blood Group</label>  
  <div class="col-md-4">
  <input id="blood" name="blood" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="dob">Date Of Birth</label>  
  <div class="col-md-4">
  <input id="dob" name="dob" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="contact">Contact</label>  
  <div class="col-md-4">
  <input id="contact" name="contact" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-success">Update Account</button>
  </div>
</div>

</fieldset>
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>