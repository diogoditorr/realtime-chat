<?php 
    session_start();
    
    if (!isset($_SESSION['unique_id'])) {
        header("location: login.php");
    }
?>

<?php include_once "templates/header.php"; ?>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php 
                    include_once "php/config.php";

                    $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
                    $sql = mysqli_query($connection, "SELECT * FROM users WHERE unique_id = {$user_id}");
                    
                    $num_rows = $sql ? mysqli_num_rows($sql) : 0;
                    if ($num_rows > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>

                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?= $row['image'] ?>" alt="">
                <div class="details">
                    <span><?= $row['first_name']." ".$row['last_name']?></span>
                    <p><?= $row['status'] ?></p>
                </div>
            </header>
        
            <div class="chat-box">
                <div class="chat outgoing">
                    <div class="details">
                        <p>Roi</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="" alt="">
                    <div class="details">
                        <p>Olá NepalláNepalláNepalláNepalláNepalláNepalláNepalláNepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepal!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="" alt="">
                    <div class="details">
                        <p>Olá NepalláNepalláNepalláNepalláNepalláNepalláNepalláNepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepal!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="" alt="">
                    <div class="details">
                        <p>Olá NepalláNepalláNepalláNepalláNepalláNepalláNepalláNepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepal!</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="" alt="">
                    <div class="details">
                        <p>Olá NepalláNepalláNepalláNepalláNepalláNepalláNepalláNepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepallá Nepal!</p>
                    </div>
                </div>
            </div>
            <form action="#" class="typing-area">
                <input type="text" class="input-field" placeholder="Type a message here...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>

    <script src="javascript/chat.js"></script>
</body>
</html>