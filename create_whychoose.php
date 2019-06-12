<?php include "header.php"?>
<?php include "sidebar.php"?>
<?php
 
$title = $description = $image = "";
$title_err = $description_err = $image_err = "";
 
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
    
    if(empty($title_err) && empty($description_err) && empty($image_err)){

        $sql = "INSERT INTO whychoose (title, description, image) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_title, $param_description, $param_image);
            
            $param_title = $title;
            $param_description = $description;
            $param_image = "images/".$filename;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: whychoose_index.php");
                echo 'alert("message successfully sent")';
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
                    <h2>Create Why choose data record </h2>
                </div>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                    <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                        <label>Upload File</label>
                        <input type="file" name="file" class="form-control">
                        <span class="help-block"><?php echo $image_err;?></span>
                        <p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="whychoose_index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<?php include "footer.php"?>