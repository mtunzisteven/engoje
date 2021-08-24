<nav class="navbar navbar-expand-lg navbar all-nav">
  <div class="container-fluid">
    <a class="navbar-brand" href="/zalisting/">        
        <img src=" /zalisting/images/logo.png" alt="logo image">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="navbar-toggler-icon bi bi-list"></i> 
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="Home"){echo 'active';} ?>" aria-current="page" href="/zalisting/">HOME</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="Shop"){echo 'active';} ?>" aria-current="page" href="/zalisting/shop">SHOP</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="New"){echo 'active';} ?>" aria-current="page" href="/zalisting/new">NEW</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="Sale"){echo 'active';} ?>" aria-current="page" href="/zalisting/sale">SALE</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="buttons" type="submit"><i class='bi bi-search'></i></button>
      </form>
      
    </div>
  </div>
    <div class="icons-container">
        <?php 
            if(isset($_SESSION['userData']['userFirstName'])){

                echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='bi bi-person-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

            } else{
                echo "<a class='account' href='/zalisting/accounts/index.php?action=login' title='Your Account'>Login</a>";
                echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count'  id='cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

            } 
        ?>
    </div>
</nav>
<nav class="nav mobile-nav">
    <div class="bottom-nav-container">
        <a class='nav-hamburger-account user' href='/zalisting/shop' title='Your Account'><i class="fas fa-store-alt"></i></a>
        <?php 
            if(isset($_SESSION['userData']['userFirstName'])){
                
                $active = '';
                
                if($pageName=='Account'){
                    
                    $active = 'active';

                    echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='bi bi-person-fill'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='mobile-cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";
            
                }else{
                    
                    echo "<a class='nav-hamburger-account user' href='/zalisting/myaccount?action=account' title='Your Account'><i class='bi bi-person-fill'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                    echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count' id='mobile-cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

                }

            } else{
                echo "<a class='account' href='/zalisting/accounts/index.php?action=login'>Login</a>";
                echo "<a class='nav-hamburger-account shopping-wishlist' href='/zalisting/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-cart' href='/zalisting/cart?action=cart'><div class='cart-count'  id='mobile-cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

            } 
        ?>
    </div>
</nav>