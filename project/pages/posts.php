<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>posts channel</title>
    <link href="css/posts.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
   
    <div class="container">
        <button class="logout-btn shadow-sm border mt-3 mb-3">
            <a href="logout.php">Logout</a>
        </button>
    </div>

    <div class="container bg-light border border-dark rounded-2 shadow mt-4 mb-3 p-3 ">
        <h1 class="text-center">Posts Page</h1>
        <div class="d-grid gap-2 p-3" id="postLists">
        <?php

        require '../resources/config.php';

        if (!isset($_SESSION['userId'])) {
            header("Location: ../index.php");
            exit;
        }

        $login = "mysql:host=$host;dbname=$db;charset=UTF8";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            $pdo = new PDO($login, $username, $password, $options);

            if ($pdo) {
                $user_id = $_SESSION['userId'];

                $query = "SELECT * FROM `posts` WHERE userId = :id";
                $statement = $pdo->prepare($query);
                $statement->execute([':id' => $user_id]);

                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    echo '
                    <div class="row border shadow-sm post-container">
                    <a class="text-emphasis" href="post.php?id=' . $row['id'] . '">
                    '. $row['title'] . '
                    </div>';
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
        </div>
    </div>
    
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>