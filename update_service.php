<?php include "header.php"?>
<?php include "sidebar.php"?>
<?php

$title = $description = $icon = "";
$title_err = $description_err = $icon_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    } elseif(!filter_var($input_title, FILTER_SANITIZE_STRING))
    {
        $title_err = "Please enter a valid title.";
    } else{
        $title = $input_title;
    }
    
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter an description.";     
    } else{
        $description = $input_description;
    }
    
    $input_icon = trim($_POST["icon"]);
    if(empty($input_icon)){
        $icon_err = "Please enter a icon.";
    } elseif(!filter_var($input_title, FILTER_SANITIZE_STRING))
    {
        $icon_err = "Please enter a valid icon.";
    } else{
        $icon = $input_icon;
    }
    
    if(empty($title_err) && empty($description_err) && empty($icon_err)){
        $sql = "UPDATE service SET title=?, description=?, icon=? WHERE id=?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_title, $param_description, $param_icon, $param_id);
            
            $param_title = $title;
            $param_description = $description;
            $param_icon = $icon;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: service_index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($con);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM service WHERE id = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $title = $row["title"];
                    $description = $row["description"];
                    $icon = $row["icon"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($con);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update service record data</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                            <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($icon_err)) ? 'has-error' : ''; ?>">
                            <label>icon</label>
                            <input type="text" name="icon" class="form-control" value="<?php echo $icon; ?>">
                            <span class="help-block"><?php echo $icon_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="service_index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<?php include "footer.php"?>