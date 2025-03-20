<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            background: url('hospital_register_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 2px 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h2 {
            color: #005a87;
            margin-bottom: 20px;
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        button {
            width: 95%;
            padding: 12px;
            background-color: #005a87;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #004060;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    <form action="register_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
