<?php include "header.php"?>
<?php include "sidebar.php"?>
   <div class="wrapper">
   	<div class="container-fluid">
   		<div class="row">
            <div class="col-md-12">
            	<div class="page-header clearfix">
	                <h2 class="pull-left">Service datamanagerment</h2>
	                <a href="create_service.php" class="btn btn-success float-right">Add New</a>
            	</div>
            	<br>
            	<br>
            	<?php 
            		$sql = "SELECT * from service";
            		if($res = mysqli_query($con,$sql)){
            			if(mysqli_num_rows($res) > 0){
            				echo "<table class='table table-bordered text-center'>";
            					echo "<thead>";
            						echo "<tr class='table-info text-white text-center'>";
	            						echo "<th scope='col'>Id</th>";
	            						echo "<th scope='col'>Title</th>";
	            						echo "<th scope='col'>Description</th>";
	            						echo "<th scope='col'>Icon</th>";
	            						echo "<th scope='col'>Action</th>";
	            					echo "</tr>";
	            				echo "</thead>";
	            				echo "<tbody>";	
	            				while($row = mysqli_fetch_array($res)){
	            					echo "<tr>";
	            						echo "<th scope='row'>".$row['id']."</th>";
	            						echo "<td>".$row['title']."</td>";
	            						echo "<td>".$row['description']."</td>";
	            						echo "<td>".$row['icon']."</td>";
	            						echo "<td>";
	            							echo "<a href='read_service.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update_service.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete_service.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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