<?php
    include('database_connection.php');
    
    if(!empty($_POST['username'])){
        $username = $_POST['username'];
    $query = "DELETE FROM tbl_twitter_user WHERE username = $username";

    echo $username;
    if($connect->query($query) == TRUE) {
        echo "Record deleted successfully";
    }
        else{
            echo " Record deleted successfully";
        }
}
?>


<html>
<head>

</head>
<body>
<form action = "delete.php" method = "post">
    <label>Username</label>
    <input type= "text" name = "username">
    <input type= "submit">

</form>

</body>
</html>
