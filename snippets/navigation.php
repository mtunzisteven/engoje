<nav class="nav desktop-nav">
    <div class="nav-right-block">
        <img src=" /zalisting/images/logo.jpg" alt="logo image">
        <ul class="nav-desktop-items">
            <li class="nav-list-item"><a href=" /zalisting/" class="nav-list-link <?php if($pageName=="Home"){echo 'active';} ?>">Home</a></li>
            <li class="nav-list-item"><a href=" /about" class="nav-list-link <?php if($pageName=="Shop"){echo 'active';} ?>">Shop</a></li>
            <li class="nav-list-item"><a href=" /services" class="nav-list-link <?php if($pageName=="Sale"){echo 'active';} ?>">Sale</a></li>
            <li class="nav-list-item"><a href=" /contact" class="nav-list-link <?php if($pageName=="New"){echo 'active';} ?>">New</a></li>
        </ul>
    </div>
    <div class="fa-item-container">
        <i class='nav-hamburger-account fa fa-search'></i>
        <div class="fa-items-container">
            <?php 
                if(isset($_SESSION['userData']['userFirstName'])){
                    echo "<a class='nav-hamburger-account user' href='/zalisting/view/admin.php'><i class='nav-hamburger-account fa fa-user'></i></a>";
                    echo "<i class='nav-hamburger-account fa fa-shopping-cart'></i>";
                } else{
                    echo "<a class='account' href='/zalisting/accounts/index.php?action=login'>Login</a>";
                } 
            ?>
        </div>
    </div>
</nav>

<nav class="nav mobile-nav">

    <div class="nav-menu-logo">
        <i class="nav-hamburger-menu fa fa-bars"></i>
        <img src=" /zalisting/images/logo.jpg" alt="logo image">
    </div>
    <div class="fa-item-container">
        <i class='nav-hamburger-account fa fa-search'></i>
        <div >
            <?php 
                if(isset($_SESSION['userData']['userFirstName'])){
                    echo "<a class='nav-hamburger-account ' href='/zalisting/view/admin.php'><i class='nav-hamburger-account fa fa-user'></i></a>";
                    echo "<i class='nav-hamburger-account fa fa-shopping-cart'></i>";
                } else{
                    echo "<a class='account' href='/zalisting/accounts/index.php?action=login'>Login</a>";
                } 
            ?>
        </div>    
    </div>

    <div class="nav-hamburger-container hidden">

        <div class="nav-hamburger-top">
            <div class="fa-item-container">
                <img src=" /zalisting/images/logo.jpg" alt="logo image">
                <?php 
                if(isset($_SESSION['userData']['userFirstName'])){
                    echo "<p class='nav-hamburger-hello'>Hello ". $_SESSION['userData']['userFirstName']."</p>";
                } else{
                    echo "<a class='account' href='/zalisting/accounts/index.php?action=login'>Login</a>";
                } 
                ?>
            </div>
            <i class="nav-hamburger-close fa fa-times"></i>
        </div>
        <ul class="nav-mobile-items">
            <li class="nav-list-item"><a href=" /" class="nav-list-link <?php if($pageName=="Home"){echo 'active';} ?>">Home</a></li>
            <li class="nav-list-item"><a href=" /about" class="nav-list-link <?php if($pageName=="Shop"){echo 'active';} ?>">Shop</a></li>
            <li class="nav-list-item"><a href=" /services" class="nav-list-link <?php if($pageName=="Sale"){echo 'active';} ?>">Sale</a></li>
            <li class="nav-list-item"><a href=" /contact" class="nav-list-link <?php if($pageName=="New"){echo 'active';} ?>">New</a></li>
        </ul>
        

    </div>

</nav>