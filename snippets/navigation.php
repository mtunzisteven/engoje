<nav class="navbar navbar-expand-lg navbar all-nav" id="#">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">        
        <img src=" /images/logo.svg" alt="logo image">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="navbar-toggler-icon bi bi-list"></i> 
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="Home"){echo 'active';} ?>" aria-current="page" href="/">HOME</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="Shop"){echo 'active';} ?>" aria-current="page" href="/shop">SHOP</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="New"){echo 'active';} ?>" aria-current="page" href="/new">NEW</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if($pageName=="Sale"){echo 'active';} ?>" aria-current="page" href="/sale">SALE</a>
        </li>
      </ul>
      <form class="d-flex" action="/search/">
        <input class="form-control me-2" name="search" type="text" placeholder="Search" aria-label="Search">
        <button class="buttons" type="submit"><i class='bi bi-search'></i></button>
      </form>
      
    </div>
  </div>
    <div class="icons-container">
        <?php 
            if(isset($_SESSION['userData']['userFirstName'])){

                echo "<a class='nav-hamburger-account user' href='/myaccount?action=account' title='Your Account'><i class='bi bi-person-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-wishlist' href='/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-cart' href='/cart?action=cart'><div class='cart-count' id='cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

            } else{
                echo "<a class='account  signin' href='/accounts?action=login' title='Your Account'>Sign in</a>";
                echo "<a class='nav-hamburger-account shopping-wishlist' href='/wishlist?action=wishlist'><div class='wishlist-count' id='wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                echo "<a class='nav-hamburger-account shopping-cart' href='/cart?action=cart'><div class='cart-count'  id='cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

            } 
        ?>
    </div>
</nav>

<?php if($pageName != 'Cart' && $pageName != 'Wishlist'){ ?>

  <div class="bottom-nav-container">
      <a class='nav-hamburger-account user' href='/shop' title='Your Account'><i class="fas fa-store-alt"></i></a>
      <?php 
          if(isset($_SESSION['userData']['userFirstName'])){
              
              $active = '';
              
              if($pageName=='Account'){
                  
                  $active = 'active';

                  echo "<a class='nav-hamburger-account user' href='/myaccount?action=account' title='Your Account'><i class='bi bi-person-fill'></i></a>";
                  echo "<a class='nav-hamburger-account shopping-wishlist' href='/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                  echo "<a class='nav-hamburger-account shopping-cart' href='/cart?action=cart'><div class='cart-count' id='mobile-cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";
          
              }else{
                  
                  echo "<a class='nav-hamburger-account user' href='/myaccount?action=account' title='Your Account'><i class='bi bi-person-fill'></i></a>";
                  echo "<a class='nav-hamburger-account shopping-wishlist' href='/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
                  echo "<a class='nav-hamburger-account shopping-cart' href='/cart?action=cart'><div class='cart-count' id='mobile-cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

              }

          } else{
              echo "<a class='account signin' href='/accounts/index.php?action=login'>Sign in</a>";
              echo "<a class='nav-hamburger-account shopping-wishlist' href='/wishlist?action=wishlist' title='Wishlist'><div class='wishlist-count' id='mobile-wishlist-count'>0</div><i class='bi bi-heart-fill'></i></a>";
              echo "<a class='nav-hamburger-account shopping-cart' href='/cart?action=cart'><div class='cart-count'  id='mobile-cart-count'>0</div><i class='bi bi-cart-fill'></i></a>";

          } 
      ?>
    </div>
<?php } ?>