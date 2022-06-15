<?php
session_start();
require_once "pdo.php";
if ( isset($_POST['transdate']) && isset($_POST['item']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['invoice'])) {
  if ( $_POST['transdate']>0 && $_POST['item'] >0 && $_POST['quantity'] >0 && $_POST['price']>0 && $_POST['invoice']>0){
$sql = "INSERT INTO incomingordertable (trans_date, item, quantity, price, invoice) VALUES (:td, :item, :quan, :price, :inv)";
// echo("<pre>\n".$sql."\n</pre>\n");
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
':td' => $_POST['transdate'],
':item' => $_POST['item'],
':quan' => $_POST['quantity'],
':price' => $_POST['price'],
':inv' => $_POST['invoice'])
);
$_SESSION['message']="Data Successfully Added!";
}
else {
  $_SESSION['message']="Please enter all input with correct data type";
}
}
else {
  $_SESSION['message']="Please enter all input with correct data type";
}

if ( isset($_POST['record_id']) ) {
$sql = "DELETE FROM incomingordertable WHERE recordid = :zip";
// echo "<pre>\n$sql\n</pre>\n";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':zip' => $_POST['record_id']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Incoming Table Order Details</h2>
                    </div>
                    <?php
                    // Include config file
                    require_once "pdo.php";



                    // Attempt select query execution
                    $sql = "SELECT recordid, trans_date, item, quantity, price, invoice FROM incomingordertable";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Record ID</th>";
                                        echo "<th>Transaction Date</th>";
                                        echo "<th>Item</th>";
                                        echo "<th>Quantity</th>";
                                        echo "<th>Price</th>";
                                        echo "<th>Invoice</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['recordid'] . "</td>";
                                        echo "<td>" . $row['trans_date'] . "</td>";
                                        echo "<td>" . $row['item'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td>" . $row['invoice'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }


                    // Close connection
                    unset($pdo);
                    ?>
                  <b>Add A New Order </b>
                  <form method="post">
                  <p>Transaction Date: <input type="date" name="transdate" ></p>
                  <p>Item: <input type="text" name="item"></p>
                  <p>Quantity: <input type="text" name="quantity"></p>
                  <p>Price: <input type="text" name="price"></p>
                  <p>Invoice ID: <input type="text" name="invoice"></p>
                  <p><input type="submit" value="Add New"/></p>
                  </form>
<br>
                  <b>Delete An Order</b>
                  <br>
                  <form method="post" name="delete"><p>Record ID to Delete:
                  <input type="text" name="record_id"></p>
                  <p><input type="submit" value="Delete"/></p>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </table>

</body>
</html>
