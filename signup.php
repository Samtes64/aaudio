<?php include 'includes/header.php'?>

<?php
    $fNameError= $lNameError = $usernameError = $emailError = $passwordError = $repeatPasswordError ='';
    $fName = $lName = $username = $email = $password = $passwordRepeat = '';
    
    
    if(isset($_POST['submit'])){
      // validate first name
      if(empty($_POST['firstname'])){
        $fNameError = "First Name can not be empty!";
      }else{
        $fName= filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // validate last name
      if(empty($_POST['lastname'])){
        $lNameError = "Last Name can not be empty!";
      }else{
        $lName = filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // validate username
      if(empty($_POST['username'])){
        $usernameError = "Username can not be empty!";
      }else{
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // validate username
      if(empty($_POST['email'])){
        $emailError = "Email can not be empty!";
      }else{
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // validate password
      if(empty($_POST['password'])){
        $passwordError = "Password can not be empty!";
      }else{
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // validate password repeat
      if(empty($_POST['repeat_password'])){
        $repeatPasswordError = "Password repeat can not be empty!";
      }else{
        $passwordRepeat = filter_input(INPUT_POST,'repeat_password',FILTER_SANITIZE_SPECIAL_CHARS);
      }


      // validate password = repeatPassword
      if($password !== $passwordRepeat){
        $repeatPasswordError = "Passwords don't match";
      }

      // Add a new user
      if(empty($fNameError) && empty($lNameError) && empty($usernameError) && empty($emailError) && empty($passwordError) && empty($repeatPasswordError)){
        // echo "<p style='color:black'> $fName $lName $email $username $password $passwordRepeat </p>";
        
        // Check if the email isn't taken
        $check_email_exists_query = "select * from users where email = '$email'";
        $user_with_same_email = mysqli_query($connection, $check_email_exists_query);

        if($user_with_same_email && mysqli_num_rows($user_with_same_email)>0){
            $emailError = "This email is already taken, please use another one.";
        }

        // Check if the username isn't taken
        $check_username_exists_query = "select * from users where username = '$username'";
        $user_with_same_username = mysqli_query($connection, $check_username_exists_query);

        if($user_with_same_username && mysqli_num_rows($user_with_same_username)>0){
            $usernameError = "This username is already taken, please use another one.";
        }


        // If no remaining error, create a new instance of user
        if(empty($usernameError) && empty($emailError)){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $create_new_user_query = "INSERT INTO users (firstname, lastname, username, email, password) VALUES ('$fName', '$lName','$username','$email','$hashed_password')";
            $new_user = mysqli_query($connection, $create_new_user_query);
            if($new_user){
                // Get the ID of the newly created user
                $user_id = mysqli_insert_id($connection);
                setcookie('user_id', $user_id, time() + 86400, '/'); // Expires in 24 hours

                // Redirect to the feed page
                header("Location: feed.php");
                exit;
            } else {
                echo "<p style='color: red'>Error creating user: " . mysqli_error($connection) . "</p>";
            }
        }

      }

    }

?>


<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <h2>Sign Up</h2>
      <div class="form-group">
        <input type="text" placeholder="First Name"  name="firstname" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
            <?php echo $fNameError ?>
        </div>
      </div>
      <div class="form-group">
        <input type="text" placeholder="Last Name"  name="lastname" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
            <?php echo $lNameError ?>
        </div>
      </div>
      <div class="form-group">
        <input type="text" placeholder="username"  name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
            <?php echo $usernameError ?>
        </div>      
      </div>
      <div class="form-group">
        <input type="email" placeholder="Email"  name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
            <?php echo $emailError ?>
        </div>    
      </div>
      <div class="form-group">
        <input type="password" placeholder="Password"  name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
            <?php echo $passwordError ?>
        </div>
      </div>
      <div class="form-group">
        <input type="password" placeholder="Repeat Password"  name="repeat_password" value="<?php echo isset($_POST['repeat_password']) ? htmlspecialchars($_POST['repeat_password']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
            <?php echo $repeatPasswordError ?>
        </div>  
    </div>
      <button type="submit" name="submit">Sign Up</button>
    </form>
</div>
<?php include 'includes/footer.php'?>
