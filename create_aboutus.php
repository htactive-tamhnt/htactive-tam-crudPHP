<?php include "header.php"?>
<?php include "sidebar.php"?>
<?php
 
$title = $description = $icon = "";
$title_err = $description_err = $icon_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter your title.";
    }else{
        $title = $input_title;
    }
    
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter your description.";     
    } else{
        $description = $input_description;
    }
    
    $input_icon = trim($_POST["icon"]);
    if(empty($input_icon)){
        $icon_err = "Please enter the your icon.";     
    } else{
        $icon = $input_icon;
    }
    
    if(empty($title_err) && empty($description_err) && empty($icon_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO aboutus (title, description, icon) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_title, $param_description, $param_icon);
            
            $param_title = $title;
            $param_description = $description;
            $param_icon = $icon;
            
            if(mysqli_stmt_execute($stmt)){

                session_start();
                    $_SESSION["success"] = "Thành công";
                header("location: aboutus_index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($con);
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create About us data record </h2>
                </div>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                        <span class="help-block"><?php echo $title_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                        <label>Description</label>
                        <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                        <span class="help-block"><?php echo $description_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($icon_err)) ? 'has-error' : ''; ?>">
                        <label>Icon</label>
                        <input type="text" name="icon" class="form-control" value="<?php echo $icon; ?>">
                        <span class="help-block"><?php echo $icon_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="aboutus_index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<?php include "footer.php"?>