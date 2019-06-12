<?php include "header.php"?>
<?php include "sidebar.php"?>
   <div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Why choose datamanagerment</h2>
                    <a href="create_whychoose.php" class="btn btn-success float-right">Add New</a>
                </div>
                <br>
                <br>
                <?php 
                    $sql = "SELECT * from whychoose";
                    if($res = mysqli_query($con,$sql)){
                        if(mysqli_num_rows($res) > 0){
                            echo "<table class='table table-bordered text-center'>";
                                echo "<thead>";
                                    echo "<tr class='table-secondary text-white text-center'>";
                                        echo "<th scope='col-md-2'>Id</th>";
                                        echo "<th scope='col-md-2'>Title</th>";
                                        echo "<th scope='col-md-4'>Description</th>";
                                        echo "<th scope='col-md-2'>Image</th>";
                                        echo "<th scope='col-md-2'>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>"; 
                                while($row = mysqli_fetch_array($res)){
                                    echo "<tr>";
                                        echo "<th scope='row'>".$row['id']."</th>";
                                        echo "<td>".$row['title']."</td>";
                                        echo "<td>".$row['description']."</td>";
                                        echo "<td><img src='".$row['image']."' width='100' height='100'></td>";
                                        echo "<td>";
                                            echo "<a href='read_whychoose.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update_whychoose.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete_whychoose.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }   
                                echo "</tbody>";
                            echo "</table>";
                            mysqli_free_result($res);       
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
                    }
                    // Close connect
                    mysqli_close($con);
                ?>
            </div>
        </div>
   </div>
   </div>
<?php include "footer.php"?>