<?php include 'includes/header.php'?>

<?php
    $usernameError = $passwordError = '';

    if(isset($_POST['submit'])){
    // validate username
    if(empty($_POST['username'])){
        $usernameError = "Username can not be empty!";
      }else{
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
      }

    // validate password
    if(empty($_POST['password'])){
        $passwordError = "Password can not be empty!";
      }else{
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
      }
      
      if(empty($usernameError) && empty($passwordError)){
          // check if a user exists with that username
          $check_username_exists_query = "select * from users where username = '$username' LIMIT 1";
          $user_with_same_username = mysqli_query($connection, $check_username_exists_query);
          
          if(mysqli_num_rows($user_with_same_username)<1){
              $usernameError = "User doesn't exist.";
            }
          if(empty($usernameError)){
            // Check if the password is correct
            $user = mysqli_fetch_assoc($user_with_same_username);
            $hased_password = $user['password'];
            if(password_verify($password, $hased_password)){
                $user_id = $user['id'];
                setcookie('user_id', $user_id, time() + 86400, '/'); // Expires in 24 hours

                // Redirect to the feed page
                header("Location: feed.php");
            }
            else{
                $passwordError = "Password is incorrect.";
            }
        }
        }
    }
?>




<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
      <h2>Login</h2>
      <div class="form-group">
        <input type="text" placeholder="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
        <?php echo $usernameError ?>  
        </div>
      </div>
      <div class="form-group">
        <input type="password" placeholder="Password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
        <div style="background-color: inherit; color:red;">
        <?php echo $passwordError ?>  
        </div>
    </div>
      <button type="submit" name="submit">Login</button>
    </form>
</div>
<?php include 'includes/footer.php'?>
