<?php
session_start();
$today = date("Y-m-d"); // ✅ Today date for validation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Building NOC</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('images/building noc.jpeg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: top center;
            background-color: #f2f2f2;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            max-width: 600px;
            margin: 420px auto 60px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #003366;
        }

        form label {
            display: block;
            margin: 12px 0 5px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"],
        form textarea,
        form input[type="file"],
        form input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        form input[type="submit"]:hover {
            background-color: #004a99;
        }

        @media (max-width: 640px) {
            body {
                background-size: cover;
            }
            .form-container {
                margin: 300px 20px 40px 20px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Building Permission Application</h2>
    <form action="submit_application.php" method="post" enctype="multipart/form-data">

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Phone:</label>
        <input type="text" name="phone" required>

        <label>Address:</label>
        <textarea name="address" rows="3" required></textarea>

        <!-- ✅ Date field updated to allow ONLY Today -->
        <label for="application_date">Date of Application:</label>
        <input type="date" name="application_date" value="<?php echo $today; ?>" min="<?php echo $today; ?>" max="<?php echo $today; ?>" required>

        <hr>

        <label>Property Tax Receipt (PDF):</label>
        <input type="file" name="documents[property_tax]" accept=".pdf" required>

        <label>Land Ownership Proof (PDF):</label>
        <input type="file" name="documents[ownership_proof]" accept=".pdf" required>

        <label>Building Plan Approval (PDF):</label>
        <input type="file" name="documents[building_plan]" accept=".pdf" required>

        <label>Identity Proof (PDF):</label>
        <input type="file" name="documents[id_proof]" accept=".pdf" required>

        <input type="submit" value="Submit Application">
    </form>
</div>

</body>
</html>
