<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
    $query_params = array( 
            ':user_id' => $_SESSION['user']['id'], 
        );
    $query = " 
        SELECT   
            appt_name,
            time,
            date,
            detail,
            appt_for
        FROM appointment 
    "; 
     $query .= " 
            WHERE 
                user_id = :user_id 
        "; 
    try 
    { 
        // These two statements run the query against your database table. 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    } 
         
    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $stmt->fetchAll(); 
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
<br><br>
        <h2>Appointment</h2>
        <table class="table"> 
            <tr> 
                <th>Appointment Title</th> 
                <th>Time</th> 
                <th>Date</th> 
                <th>Detail</th> 
                <th>Appointment For</th> 
            </tr> 
            <?php foreach($rows as $row): ?> 
                <tr> 
                    <td><?php echo htmlentities($row['appt_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlentities($row['time'], ENT_QUOTES, 'UTF-8'); ?></td> 
                    <td><?php echo htmlentities($row['date'], ENT_QUOTES, 'UTF-8'); ?></td> 
                    <td><?php echo htmlentities($row['detail'], ENT_QUOTES, 'UTF-8'); ?></td> 
                    <td><?php echo htmlentities($row['appt_for'], ENT_QUOTES, 'UTF-8'); ?></td> 
                </tr> 
            <?php endforeach; ?> 
        </table> 
       
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>