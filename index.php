<?php
    session_start();

    // Check apakah user sudah login
    if (isset($_SESSION["username"])) {
        header("Location: dashboard.php");
        exit;
    }

    // Mengecheck apakah ada pengiriman data (post)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'] ?? ''; //username berasal dari form>input dgn name="username"
        $password = $_POST['password'] ?? '';

        // Login sederhana (username: admin, password: 1234)
        if ($username === 'admin' && $password === '1234') {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'Dosen';
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polgan Mart</title>
    <style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
      background: #f5f5f5;
    }
    main {
      width: 400px;
      margin: 100px auto;
      padding: 30px;
      background: white;
      box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.34);
      border-radius: 8px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .msg{
      color: red;
      text-align: center;
      margin-bottom: 15px;
      background: #ffe0e0;
      padding: 10px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: blue;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    #batal{
      width: 100%;
      padding: 10px;
      background-color: #adaaaaff;
      color: #333;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }
    p {
      text-align: center;
      margin-top: 20px;
      color: #777;
    }
  </style>
  </head>
  <body>
    <main>
      <h1>Polgan Mart</h1> 
       <?php
        if (isset($error)) {
            echo "<p class='msg'>$error</p>";
        }
      ?>
      <form action="index.php" method="post">
        <!-- Pengiriman data-->
        Username : <input type="text" name="username" required /><br /><br />
        <!--required wajib diisi-->
        Password :
        <input type="password" name="password" required /><br /><br />
        <input type="submit" value="Login" />
        <button id="batal">Batal</button>
        <p>© Polgan Mart 2025</p>
      </form>
    </main>
  </body>
</html>
