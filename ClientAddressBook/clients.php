<?php
    session_start();

    if(!$_SESSION['loggedInUser']){
        header('Location: index.php');
    }
    include('includes/header.php');
    include('includes/connection.php');

    if(isset($_GET['alert'])){
        if($_GET['alert'] == 'success'){
            $alertMessage = "<div class='alert alert-success'><strong>Successfull</strong>! New client added.<a data-dismiss='alert' class='close'>&times;</a></div>";
        }else if($_GET['alert'] == 'updatesuccess'){
            $alert = "<div class = 'alert alert-success'>Client updated successfully<a class='close' data-dismiss='alert'>&times;</a></div>";
        }else if($_GET['alert'] == 'deleted'){
            $alertMsg = "<div class = 'alert alert-danger'>Client deleted successfully<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }

    $query = "SELECT * FROM clients";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);
?>

<h1>Client Address Book</h1>
<?php echo $alertMessage;?>
<?php echo $alert;?>
<?php echo $alertMsg;?>
<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>

    <?php 
    if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    
                    echo "<td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['phone']."</td><td>".$row['address']."</td><td>".$row['company']."</td><td>".$row['notes']."</td>";
                    
                    echo '<td><a href="edit.php?id='.$row['id'].'" type = "button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>';
                    
                    echo "</tr>";
                }
            }else{
                echo '<div class="alert alert-warning lead">You have no <b>clients</b>!</div>';
            }
            
            mysqli_close($conn);
    ?>
    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-md btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php
include('includes/footer.php');
?>