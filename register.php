<?php 
    function register(){
    require("common.php");
    if(!empty($_POST)) 
    {  
        if(empty($_POST['name'])) 
        { 
            die("Please enter a name."); 
        }
        if(empty($_POST['username'])) 
        { 
            die("Please enter a username."); 
        } 
        if(empty($_POST['password'])) 
        { 
            die("Please enter a password."); 
        } 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        
        $row = $stmt->fetch(); 
         
        // If a row was returned, then we know a matching username was found in 
        // the database already and we should not allow the user to continue. 
        if($row) 
        { 
            die("This username is already in use"); 
        } 
         
        // Now we perform the same type of check for the email address, in order 
        // to ensure that it is unique. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         
        $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                salt, 
                email,
                name,
                sex 
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email,
                :name,
                :sex
            ) 
        "; 
        
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        $password = hash('sha256', $_POST['password'] . $salt); 
         
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'],
            ':name' => $_POST['name'],
            ':sex' => $_POST['sex']
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
        echo 'Successful!';
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
  }
?>
 

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>Justified Nav Template for Bootstrap</title>
    <link href="css/justified-nav.css" rel="stylesheet">
    <link href="css/create_ac/style.css" rel="stylesheet">
  </head>

  <body>
    <h1 class="register-title">Welcome</h1>
    <form class="register" action="register.php" method="post">
      <div class="register-switch">
        <input type="radio" name="sex" value="Female" id="sex_f" class="register-switch-input" checked>
        <label for="sex_f" class="register-switch-label">Female</label>
        <input type="radio" name="sex" value="Male" id="sex_m" class="register-switch-input">
        <label for="sex_m" class="register-switch-label">Male</label>
      </div>
      <input type="text" name="name" class="register-input" placeholder="Name">
      <input type="text" name="username" class="register-input" placeholder="Username">
      <input type="email" name="email" class="register-input" placeholder="Email address">
      <input type="password" name="password" class="register-input" placeholder="Password">
      <input type="submit" value="Create Account" class="register-button">
    </form>
    <div class="error-title">
<?php 
     register(); 
?>
    </div>
    <a class="home-title" href="index.php"><p >Back to Home</p></a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>