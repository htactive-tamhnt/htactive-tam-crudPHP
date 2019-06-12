<?php include "header.php"?>
<?php include "sidebar.php"?>
<?php

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    
    $sql = "SELECT * FROM service WHERE id = ?";
    
    if($stmt = mysqli_prepare($con, $sql)){

        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($res) == 1){
                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                
                $name = $row["title"];
                $address = $row["description"];
                $salary = $row["icon"];

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
} else{
    header("location: error.php");
    exit();
}
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View service data</h1>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <p class="form-control-static"><?php echo $row["title"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p class="form-control-static"><?php echo $row["description"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <p class="form-control-static"><?php echo $row["icon"]; ?></p>
                    </div>
                    <p><a href="service_index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
<?php include "footer.php"?>
