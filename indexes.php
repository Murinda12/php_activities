<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
</head>
<body style="font-family:Arial; background:#f2f2f2; padding:20px;">
   
    
<div style="text-align:center; margin-bottom:15px;">
<a href="add.php"
style="text-decoration:none; background:#28a745; padding:10px 15px; color:white; border-radius:5px;">Add New Customer</a>
</div>

</table>

</body>
</html>
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['logged_in']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['logged_in'] = true;
}

$connect = new mysqli("localhost", "root", "", "classb");

if (isset($_POST["submit"])) {
    $phone_number = $_POST['number'];
    $firstname = $_POST['fn'];
    $lastname = $_POST['ln'];
    $gender = $_POST['gender'];
    $province = $_POST['province'];
    
    $phone_number = mysqli_real_escape_string($connect, $phone_number);
    $firstname = mysqli_real_escape_string($connect, $firstname);
    $lastname = mysqli_real_escape_string($connect, $lastname);
    $gender = mysqli_real_escape_string($connect, $gender);
    $province = mysqli_real_escape_string($connect, $province);
    
    $stmt = $connect->prepare("INSERT INTO information (phone_number, firstname, lastname, gender, province) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $phone_number, $firstname, $lastname, $gender, $province);
    
    if ($stmt->execute()) {
        $success = "Record added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(145deg, #f093fb, #f5576c);
            min-height: 100vh;
            padding: 20px;
        }
        
        .main-header {
            background: white;
            max-width: 1320px;
            margin: 0 auto 25px;
            padding: 22px 35px;
            border-radius: 15px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .main-header h1 {
            color: #f5576c;
            font-size: 26px;
            font-weight: 800;
        }
        
        .account-area {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        
        .display-name {
            color: #2c3e50;
            font-weight: 600;
            font-size: 15px;
        }
        
        .logout-link {
            background: linear-gradient(145deg, #f093fb, #f5576c);
            color: white;
            padding: 11px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .logout-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
        }
        
        .main-grid {
            display: flex;
            gap: 25px;
            max-width: 1320px;
            margin: 0 auto;
            align-items: flex-start;
        }
        
        .create-section {
            background: white;
            flex: 0 0 390px;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
        }
        
        .create-heading {
            font-size: 24px;
            font-weight: 800;
            color: #f5576c;
            margin-bottom: 28px;
            text-align: center;
            padding-bottom: 16px;
            border-bottom: 3px solid #f5576c;
        }
        
        .status-alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-error {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626;
            border: 2px solid rgba(239, 68, 68, 0.25);
        }
        
        .status-success {
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
            border: 2px solid rgba(34, 197, 94, 0.25);
        }
        
        .field-group {
            margin-bottom: 20px;
        }
        
        .field-group label {
            display: block;
            color: #374151;
            font-weight: 700;
            margin-bottom: 7px;
            font-size: 14px;
        }
        
        .field-group input {
            width: 100%;
            padding: 13px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .field-group input:focus {
            outline: none;
            border-color: #f5576c;
            box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1);
        }
        
        .create-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(145deg, #f093fb, #f5576c);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .create-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
        }
        
        .display-section {
            flex: 1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .display-header {
            padding: 24px 32px;
            background: linear-gradient(145deg, #f093fb, #f5576c);
        }
        
        .display-header h2 {
            color: white;
            font-size: 22px;
            font-weight: 800;
        }
        
        .table-wrapper {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
        }
        
        th {
            padding: 16px 18px;
            text-align: left;
            font-weight: 800;
            color: #f5576c;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1.5px;
        }
        
        td {
            padding: 16px 18px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            font-size: 14px;
        }
        
        tbody tr {
            transition: background 0.2s;
        }
        
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        
        tbody tr:hover {
            background: #fef2f8;
        }
        
        .btn-link {
            color: #f5576c;
            text-decoration: none;
            font-weight: 700;
            padding: 6px 13px;
            border-radius: 8px;
            transition: all 0.3s;
            display: inline-block;
            font-size: 13px;
        }
        
        .btn-link:hover {
            background: #f5576c;
            color: white;
            transform: scale(1.05);
        }
        
        @media (max-width: 1024px) {
            .main-grid {
                flex-direction: column;
            }
            
            .create-section {
                flex: 1;
                width: 100%;
                max-width: 520px;
                margin: 0 auto 25px;
            }
            
            .main-header {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
        }
        
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 11px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="main-header">
        <h1>Information Management System</h1>
        <div class="account-area">
            <span class="display-name">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </div>

    
                
            </div>
            <div class="table-wrapper">
                
<tr style="background:#333; color:white;">


<table border="1" cellpadding="8" table border="1" cellpadding="8" cellspacing="0" style="width:100%; background:white; border-collapse:collapse;">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Actions</th>
</tr>

<?php
$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>".$row['id']."</td>
        <td>".$row['name']."</td>
        <td>".$row['email']."</td>
        <td>".$row['phone']."</td>
        <td>".$row['address']."</td>
        <td>
            <a href='edit.php?id=".$row['id']."'>Edit</a> |
            <a href='delete.php?id=".$row['id']."'>Delete</a>
        </td>
    </tr>";
}
?>
            </div>
        </div>
    </div>
</body>
</html>