<?php

require 'resources/config.php';

$login = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try{
    $pdo = new PDO($login, $username, $password, $options);

    if($pdo){

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($sql);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if($user){
                if("password" === $password){
                    $_SESSION['userId'] = $user['id'];

                   header("Location: pages/posts.php");
                   exit;
                }
                else{
                    echo 'Wrong password';
                }

            }
            else{
                echo "user not found";
            }
            
        }
 
        
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="index.css?v=<?php echo time(); ?>" rel="stylesheet"> 
</head>
<body class="d-flex align-items-center justify-content-center shadow bg-light">
    <div class="form-container container border border-dark rounded-2 bg-light p-3 shadow-lg">
        <form id="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
               <div class="mb-3 mt-4">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" id="username" placeholder="Enter username" name="username" required>
               </div>

               <div class="mb-3 mt-4">
                   <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" placeholder="Enter password" name="password" required>
               </div>

               <div class="mb-3 mt-5">
                
               <button class="form-control" id="submit">Login</button>
               </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>