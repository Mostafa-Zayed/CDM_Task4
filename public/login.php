<?php
// Connect To Database
include_once ('../private/db/connect.php');
// Check If User Login
if(isset($_SESSION['user_id'])){
    // redirect To Index Page
    header('location:index.php');
}
// Include Functions file
include_once '../private/functions.php';
$message = '';
if(isset($_POST['login']) && !empty($_POST['login'])){
    // Check if email is existing to User
    $query = "SELECT * FROM `users` Where email = :email";
    $statement = $connect->prepare($query);
    $statement->execute(array(
        ':email' => $_POST['email']
    ));
    $count = $statement->rowCount();
    if($count > 0){
        $result = $statement->fetchAll();
        $pass = md5($_POST['password']);
        foreach ($result as $row){
            // Check Password and create Session
            if($row['password'] === $pass){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                // redirect To Index page
                header('location:index.php');
            }else{
                // display Password Message Error
                $message = "<lable>Wrong Password</lable>";
            }

        }

    }else{
        // display Email Message Error
        $message = "<lable>Wrong Email</lable>";
    }

}
?>
<!-- Include Navbar -->
<?php include_once ('../includes/navbar.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php
            // display Error Message if found
            if(!empty($message)){ ?>
                <div class="alert alert-danger">
                    <ul>
                        <li><?=$message;?></li>
                    </ul>
                </div>
            <?php } ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Login</h3>
                </div>
                <div class="panel-body">
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <?php $input = 'email'; ?>
                            <label for="<?=$input;?>"><?=ucfirst($input);?> :</label>
                            <input type="email" id="<?=$input;?>" name="<?=$input;?>" class="form-control" placeholder="<?=ucfirst($input);?>" value="<?=isset($_POST[$input])?$_POST[$input]:''?>">
                        </div>
                        <div class="form-group">
                            <?php $input = 'password'; ?>
                            <label for="<?=$input;?>"><?=ucfirst($input);?> :</label>
                            <input type="password" id="<?=$input;?>" name="<?=$input;?>" class="form-control" placeholder="<?=ucfirst($input);?>">
                        </div>
                        <div class="form-group">
                            <?php $input = 'login'; ?>
                            <input type="submit" id="<?=$input;?>" name="<?=$input;?>" value="<?=ucfirst($input);?>" class="btn btn-default pull-right">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Include Footer -->
<?php include_once ('../includes/footer.php'); ?>