<nav class="nav desktop-nav">
    <div class="nav-right-block">
        <img src=" /zalisting/images/logo.png" alt="logo image">
        <ul class="nav-desktop-items">
            <li class="nav-list-item"><a href=" /zalisting/" class="nav-list-link <?php if($pageName=="Home"){echo 'active';} ?>">HOME</a></li>
            <li class="nav-list-item"><a href=" /zalisting/shop" class="nav-list-link <?php if($pageName=="Shop" || $pageName=="Cart" || $pageName=="Checkout" || $pageName=="Wishlist"){echo 'active';} ?>">SHOP</a></li>
            <li class="nav-list-item"><a href=" /zalisting/new" class="nav-list-link <?php if($pageName=="Sale"){echo 'active';} ?>">SALE</a></li>
            <li class="nav-list-item"><a href=" /zalisting/sale" class="nav-list-link <?php if($pageName=="New"){echo 'active';} ?>">NEW</a></li>
        </ul>
    </div>
    <div class="fa-item-container">
        <i class='nav-hamburger-account fa fa-search'></i>
        <div class="fa-items-container">
            <?php 
                if(isset($_SESSION['userData']['userFirstName'])){
                    
                    $active = '';
                    
                    if($pageName=='Account'){
                        
                        $active = 'active';

                        echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='$active nav-hamburger-account fa fa-user'></i></a>";
                        echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='nav-hamburger-account fa fa-heart'></i></a>";
                        echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='cart-count'>0</div><i class='nav-hamburger-account fa fa-shopping-basket'></i></a>";
                
                    }else{
                        
                        echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='$active nav-hamburger-account fa fa-user'></i></a>";
                        echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='nav-hamburger-account fa fa-heart'></i></a>";
                        echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='cart-count'>0</div><i class='nav-hamburger-account fa fa-shopping-basket'></i></a>";
   
                    }

                } else{
                    echo "<a class='account account-button  button' href='/zalisting/accounts/index.php?action=login'>Login</a>";
                    echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='nav-hamburger-account fa fa-heart'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count'  id='cart-count'>0</div><i class='nav-hamburger-account fa fa-shopping-basket'></i></a>";

                } 
            ?>
        </div>
    </div>
</nav>

<nav class="nav mobile-nav">

    <div class="nav-menu-logo">
        <i class="nav-hamburger-menu fa fa-bars"></i>
        <img src=" /zalisting/images/lightlogo.png" alt="logo image">
        <i class='nav-hamburger-account fa fa-search'></i> 
    </div>

    <div class="bottom-nav-container">
        <a class='nav-hamburger-account user' href='/zalisting/shop' title='Your Account'><i class='nav-hamburger-account fa fa-home'></i></a>
        <?php 
            if(isset($_SESSION['userData']['userFirstName'])){
                
                $active = '';
                
                if($pageName=='Account'){
                    
                    $active = 'active';

                    echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='$active nav-hamburger-account fa fa-user'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='nav-hamburger-account fa fa-heart'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='mobile-cart-count'>0</div><i class='nav-hamburger-account fa fa-shopping-basket'></i></a>";
            
                }else{
                    
                    echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='$active nav-hamburger-account fa fa-user'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='nav-hamburger-account fa fa-heart'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='mobile-cart-count'>0</div><i class='nav-hamburger-account fa fa-shopping-basket'></i></a>";

                }

            } else{
                echo "<a class='account account-button  button' href='/zalisting/accounts/index.php?action=login'>Login</a>";
                echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='nav-hamburger-account fa fa-heart'></i></a>";
                echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count'  id='cart-count'>0</div><i class='nav-hamburger-account fa fa-shopping-basket'></i></a>";

            } 
        ?>
    </div>

    <div class="nav-hamburger-container hidden">

        <div class="nav-hamburger-top">
            <div class="fa-item-container">
                <img src=" /zalisting/images/lightlogo.png" alt="logo image">
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
            <li class="nav-list-item"><a href=" /zalisting/" class="nav-list-link <?php if($pageName=="Home"){echo 'active';} ?>">HOME</a></li>
            <li class="nav-list-item"><a href=" /zalisting/shop" class="nav-list-link <?php if($pageName=="Shop"){echo 'active';} ?>">SHOP</a></li>
            <li class="nav-list-item"><a href=" /zalisting/new" class="nav-list-link <?php if($pageName=="Sale"){echo 'active';} ?>">SALE</a></li>
            <li class="nav-list-item"><a href=" /zalisting/sale" class="nav-list-link <?php if($pageName=="New"){echo 'active';} ?>">NEW</a></li>
        </ul>
        

    </div>

</nav>