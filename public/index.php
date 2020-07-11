<?php
session_start();
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    header('location:login.php');
}
?>
<?php include_once ('../includes/navbar.php');?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Home Page</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success">
                        <?='Welcom Back '.ucfirst($_SESSION['name']);?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include_once ('../includes/footer.php'); ?>
