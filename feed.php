<?php include 'config/db.php'; ?>


<?php


if (isset($_POST['search'])) {
    // Sanitize and retrieve the search query
    $searchQuery = filter_var($_POST['searchQuery'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    // SQL query to search for users
    $sql = "SELECT * FROM users WHERE username LIKE '%$searchQuery%'";

    // Execute the query
    $result = mysqli_query($connection, $sql);
    $users_searched = '';
var_dump(mysqli_fetch_assoc($result));
    
    // Check if any results were found
    if (mysqli_num_rows($result) > 0) {
        $users_searched = mysqli_fetch_assoc($result);
    } else {
    }

    // Free the result set
}
?>


<section class="home">
    <div class="home-left">
        <?php include 'sidebar.php' ?>
    </div>
    <div class="home-right">
        <!-- SEARCH -->
        <form method="GET" action="searchuser.php" class="search_form">
            <input type="text" name="search" placeholder="Enter a username" class="input-search">
            <button type="submit" name="submit" class="btn btn-secondary">Search</button>
        </form>

        
        <div class="feed">
            <div class="accounts">
                <?php $Query = "SELECT * from users";
                $users = mysqli_query($connection,$Query);
                ?>

                <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                
                <div class="account">
                    <h1><?=$user['firstname']?></h1>
                    <button class="btn btn-secondary">Follow</button>
                </div>
                    <?php endwhile?>

            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php' ?>