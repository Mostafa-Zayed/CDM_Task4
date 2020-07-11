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
$errors = array();

if(isset($_POST['register']) && !empty($_POST['register'])){
    // Check if Fields is Not Empty
    $fields = array('name','email','password','phone','address');
    foreach($fields as $field){
        $value = trim($_POST[$field]);
        if(!has_presence($value)){
            $errors[$field] = ucfirst($field).' Cant Not be blank';
        }
    }
    // Check if Fields Min Length is Valid
    $fields = array('name'=>3,'email'=>6,'password'=>6,'phone'=>8,'address'=>5);
    foreach ($fields as $field => $min){
        $value = trim($_POST[$field]);
        if(!min_length($value,$min)){
            $errors[$field] = ucfirst($field).' Min length equal '.$min;
        }
    }
    // Check if Fields Max Length is Valid
    $fields = array('name'=>70,'email'=>150,'password'=>255,'phone'=>20,'address'=>150);
    foreach ($fields as $field => $max){
        $value = trim($_POST[$field]);
        if(!max_length($value,$max)){
            $errors[$field] = ucfirst($field).' Max length equal '.$max;
        }
    }
    // Check if Fields Password and Re-password Dont Match
    if($_POST['password'] !== $_POST['re_password']){
        $errors[] = 'Passwords Dont Matches';
    }

    // Check if email is already existing
    $query = "SELECT * FROM `users` Where email = :email";
    $statement = $connect->prepare($query);
    $statement->execute(array(
        ':email' => $_POST['email']
    ));
    $count = $statement->rowCount();
    if($count > 0){
        $errors[] = 'Sorry Email is EXists';
    }
    // Start Insert Data in Database if Not found errors
    if(empty($errors)){
        $name = fillterData($_POST['name']);
        $email = fillterData($_POST['email']);
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $password = md5($_POST['password']);
        $phone = fillterData($_POST['phone']);
        $address = fillterData($_POST['address']);

        $query = 'INSERT INTO users (name,email,password,phone,address) VALUES(:name,:email,:password,:phone,:address) ';
        $statement = $connect->prepare($query);
        $result = $statement->execute(array(
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone,
            ':address' => $address
        ));
        // if user register redirect To Index page
        if(isset($result)){
            header('location:index.php');
        }
    }
}
?>
<!-- Include Navbar File -->
<?php include_once ('../includes/navbar.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php
            if(!empty($errors)){ ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error) {?>
                            <li><?=$error;?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>
                <div class="panel-body">
                    <form action="register.php" method="POST">
                        <?php $input = 'name'; ?>
                        <div class="form-group">
                            <label for="<?=$input;?>"><?=ucfirst($input);?> :</label>
                            <input type="text" id="<?=$input;?>" name="<?=$input;?>" class="form-control" placeholder="<?=ucfirst($input);?>" value="<?=isset($_POST[$input])?$_POST[$input]:''?>">
                        </div>
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
                            <?php $input = 're_password'; ?>
                            <label for="<?=$input;?>"><?=ucfirst($input);?> :</label>
                            <input type="password" id="<?=$input;?>" name="<?=$input;?>" class="form-control" placeholder="<?=ucfirst($input);?>">
                        </div>
                        <div class="form-group">
                            <?php $input = 'phone'; ?>
                            <label for="<?=$input;?>"><?=ucfirst($input);?> :</label>
                            <input type="text" id="<?=$input;?>" name="<?=$input;?>" class="form-control" placeholder="<?=ucfirst($input);?>" value="<?=isset($_POST[$input])?$_POST[$input]:''?>">
                        </div>
                        <div class="form-group">
                            <?php $input = 'address'; ?>
                            <label for="<?=$input;?>"><?=ucfirst($input);?> :</label>
                            <input type="text" id="<?=$input;?>" name="<?=$input;?>" class="form-control" placeholder="<?=ucfirst($input);?>" value="<?=isset($_POST[$input])?$_POST[$input]:''?>">
                        </div>
                        <div class="form-group">
                            <?php $input = 'register'; ?>
                            <input type="submit" id="<?=$input;?>" name="<?=$input;?>" value="<?=ucfirst($input);?>" class="btn btn-default pull-right">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- Include Footer File -->
<?php include_once ('../includes/footer.php'); ?>