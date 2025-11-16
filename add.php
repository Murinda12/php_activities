<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
<title>Add Customer</title>
</head>
<body style= "font-family: Arial; background:#f2f2f2; padding:20px;">

<h2 style="text-align:center;">Add Customer</h2>
<div style="width:350px; margin:auto; background:white; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,.1);">

<form method="post">
Name: <input type="text" name="name" required style="width:100%; padding:8px; margin-bottom:8px; border:1px solid #ccc; border-radius:5px;"><br><br>
Email: <input type="email" name="email" required style="width:100%; padding:8px; margin-bottom:8px; border:1px solid #ccc; border-radius:5px;"><br><br>
Phone: <input type="text" name="phone" required style="width:100%; padding:8px; margin-bottom:8px; border:1px solid #ccc; border-radius:5px;"><br><br>
Address: <textarea name="address" style="width:100%; padding:8px; margin-bottom:10px; border:1px solid #ccc; border-radius:5px;"></textarea><br><br>

<button type="submit" name="save" style="width:100%; background:#28a745; color:white; padding:10px; border:none; border-radius:5px; cursor:pointer;">Save</button>
</form>

<?php
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO customers (name, email, phone, address)
            VALUES ('$name', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo "Customer added successfully!";
        echo "<br><a href='index.php'>Back</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

</body>
</html>
