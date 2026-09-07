<header>
    <div id="title">The Rabbit Hole</div>
</header>
<nav>
    <div id="nav-items">
        <a href="/">Home</a>
        <a href="/groups">Groups</a>
        
        <?php
            if(isset($_SESSION['username'])){
                echo " <a href='/topics'>Topics</a> ";
                echo " <a href='/me'>Me</a> ";
                echo " <a href='/logout.php'>Log out</a> ";
            }else{
                echo " <a href='/login'>Log in</a> ";
            }
        ?>
    </div>
</nav>
<main>