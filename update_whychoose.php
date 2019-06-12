<?php include "header.php"?>
<?php include "sidebar.php"?>
<?php

$title = $description = $image = "";
$title_err = $description_err = $image_err = "";
 
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
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["file"]["name"];
            $filetype = $_FILES["file"]["type"];
            $filesize = $_FILES["file"]["size"];
        
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
        
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
        
            if(in_array($filetype, $allowed)){
                if(file_exists("images/" . $filename)){
                    echo $filename . " is already exists.";
                } else{
                    move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $filename);
                    echo "Your file was uploaded successfully.";
                } 
            }else{
                echo "Error: There was a problem uploading your file. Please try again."; 
            }
        }else{
            echo "Error: " . $_FILES["file"]["error"];
        }
    }

    if(empty($filename)){
        if(empty($title_err) && empty($description_err) && empty($image_err)){
        $sql = "UPDATE whychoose SET title=?, description=? WHERE id=?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "ssi", $param_title, $param_description, $param_id);
            
            $param_title = $title;
            $param_description = $description;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: whychoose_index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        } 
        mysqli_stmt_close($stmt);
        }
    }else{
        if(empty($title_err) && empty($description_err) && empty($image_err)){
        $sql = "UPDATE whychoose SET title=?, description=?, image=? WHERE id=?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_title, $param_description, $param_image, $param_id);
            
            $param_title = $title;
            $param_description = $description;
            $param_image = "images/".$filename;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: whychoose_index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($con);
}else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM whychoose WHERE id = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $title = $row["title"];
                    $description = $row["description"];
                    $image = $row["image"];
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
                        <h2>Update Why choose record data</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
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
                        <div>
                            <label>Your current image</label>
                            <div><img src="<?php echo $image?>" width=200 height=200></div>
                            <p><strong>Warning:</strong>If you want change this image, you can choose upload file bellow:</p>
                        </div>
                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Edit upload File</label>
                            <input type="file" name="file" class="form-control">
                            <span class="help-block"><?php echo $image_err;?></span>
                            <p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="whychoose_index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<?php include "footer.php"?>