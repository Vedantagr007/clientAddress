<?php
    session_start();
    
    if(!$_SESSION['loggedInUser']){
        header('Location: index.php');
    }

    $clientID = $_GET['id'];

    include('includes/connection.php');
    
    include('includes/functions.php');

    $query = "SELECT * FROM clients WHERE id = '$clientID'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        // we have data
        // set some variables
        while($row = mysqli_fetch_assoc($result)){
            $clientName = $row['name'];
            $clientEmail = $row['email'];
            $clientPhone = $row['phone'];
            $clientCompany = $row['company'];
            $clientAddress = $row['address'];
            $clientNotes = $row['notes'];
        }
    }else{
        $alertMessage = "<div class = 'alert alert-warning'>Nothing to see here. <a href = 'clients.php'>Head Back</a>.</div>";
    }

    if(isset($_POST['update'])){
        $clientName    = validateFormData($_POST['clientName']);
        $clientEmail   = validateFormData($_POST['clientEmail']);
        $clientPhone   = validateFormData($_POST['clientPhone']);
        $clientCompany = validateFormData($_POST['clientCompany']);
        $clientAddress = validateFormData($_POST['clientAddress']);
        $clientNotes   = validateFormData($_POST['clientNotes']);

        // new db query
        $query = "UPDATE clients
                  SET name = '$clientName',
                      email = '$clientEmail',
                      phone = '$clientPhone',
                      company = '$clientCompany',
                      address = '$clientAddress',
                      notes = '$clientNotes' WHERE id = '$clientID'";
        $result = mysqli_query($conn, $query);

        if($result){
            header("Location: clients.php?alert=updatesuccess");
        }else{
            echo "<div class='alert alert-warning'>Error updating record. ".mysqli_error($conn)."</div>";
        }
    }

    if(isset($_POST['delete'])){
        $alert =  "<div class = 'alert alert-danger'>
                <p>Are you sure you want to remove your client. No take backs!</p><br>
                <form action = '".htmlspecialchars($_SERVER['PHP_SELF'])."?id=$clientID' method='post'>
                    <input type = 'submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'/>
                    <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, No Thanks!</a>
                </form>
              </div>";
    }

    // if confirm delete message is clicked
    if(isset($_POST['confirm-delete'])){
        $query = "DELETE FROM clients WHERE id = '$clientID'";
        $result = mysqli_query($conn, $query);

        if($result){
            header("Location: clients.php?alert=deleted");
        }else{
            echo "Error deleting user. ".mysqli_error($conn);
        }
    }

    mysqli_close($conn);

    include('includes/header.php');
?>

<h1>Edit Client</h1>
<?php echo $alert;?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php echo $clientID;?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $clientAddress;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany;?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $clientNotes;?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>