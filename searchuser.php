<?php include 'config/db.php';
if (isset($_GET['submit']) ) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM users WHERE username LIKE '%$search%' ";
    $users = mysqli_query($connection, $query);
} else {
    header('location: ' . 'feed.php');
} ?>
<section class="home">
    <div class="home-left">
        <?php include 'sidebar.php' ?>
    </div>
    <div class="home-right">
       

    <?php if (mysqli_num_rows($users)>0) : ?>
        <div class="feed">
            <div class="accounts">
                <?php while($user = mysqli_fetch_assoc($users)) : ?>
                <div class="account">
                    <h1><?=$user['username']?></h1>
                    <a class="btn btn-secondary" href="follow.php?id=<?=$user['id']?>">Follow</a>
                </div>
                <?php endwhile?>


            </div>
        </div>
    <?php endif?>
    </div>
</section>
<?php include 'includes/footer.php' ?>