<?php
/**
 * This is for the side nav builder functions 
 */


//  Build Admin Side Nav display
function buildAdminSideNav(){

    $name = '';

    // for logged in user
    if(isset($_SESSION['userData']) && $_SESSION['loggedin'] && $_SESSION['userData']['userLevel']==2){
        $name = $_SESSION['userData']['userFirstName'];

      // make sure $active_tab['users'] is set
      if(isset($_SESSION['active_tab'])){

        //var_dump($_SESSION['active_tab']); exit;

          $adminSideNav = 
          '<main class="admin-dashboardnav">
              <div class="d-flex flex-column flex-shrink-0 p-3 text-white admin-nav" style="width: 280px;">
                  <a href="/engoje/myaccount/?action=account" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4">Dashboard</span>
                  </a>
                  <hr>
                  <ul class="nav nav-pills flex-column mb-auto"> 
                      <li class="nav-item">
                        <a href="/engoje/admin/?action=users" class="nav-link text-white '.$_SESSION['active_tab']['users'].'">
                          <i class="bi bi-people"></i>
                          &nbsp;Users
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/engoje/products/?action=product" class="nav-link text-white '.$_SESSION['active_tab']['products'].'">
                          <i class="bi bi-box-seam"></i>
                          &nbsp;Products 
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/engoje/taxonomy/?action=taxonomy" class="nav-link text-white '.$_SESSION['active_tab']['taxonomy'].'">
                          <i class="bi bi-briefcase"></i>
                          &nbsp;Taxonomy 
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/engoje/upload/" class="nav-link text-white '.$_SESSION['active_tab']['images'].'">
                          <i class="bi bi-images"></i>
                          &nbsp;Images
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/engoje/orders/?action=orders" class="nav-link text-white '.$_SESSION['active_tab']['orders'].'">
                          <i class="bi bi-truck"></i>
                          &nbsp;Orders
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/engoje/reviews/?action=reviews" class="nav-link text-white '.$_SESSION['active_tab']['reviews'].'">
                          <i class="bi bi-megaphone"></i>
                          &nbsp;Reveiws
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/engoje/sale/?action=promos" class="nav-link text-white '.$_SESSION['active_tab']['promotions'].'">
                          <i class="bi bi-tags"></i>
                          &nbsp;Promotions
                        </a>
                      </li>

                      <hr>
                      <li class="nav-item">
                        <div class="dropdown ps-3 ">
                            
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="bi bi-speedometer"></i>&nbsp;&nbsp;<strong>'.$name.'</strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Security</a></li>
                            <li><a class="dropdown-item" href="#">Addresses</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">My Account</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/engoje/accounts/index.php?action=logout">Sign out</a></li>
                            </ul>
                        </div>
                      </li>
                    </ul>

              </div>
          </main>';

          return $adminSideNav;
      }
      
    }else if(isset($_SESSION['userData']) && $_SESSION['loggedin'] && $_SESSION['userData']['userLevel'] == 3){

      // make sure $active_tab['users'] is set
      if(isset($_SESSION['active_tab'])){

        $adminSideNav = 
        '<main class="admin-dashboardnav">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white admin-nav" style="width: 280px;">
                <a href="/engoje/myaccount/?action=account" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                  <span class="fs-4">Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto"> 
                    <li class="nav-item">
                        <a href="/engoje/admin/?action=account" class="nav-link text-white '.$_SESSION['active_tab']['account'].'">
                            <i class="bi bi-speedometer"></i>
                            &nbsp;Account Home
                        </a>
                    </li>
                    <li>
                    <a href="/engoje/admin/?action=users" class="nav-link text-white '.$_SESSION['active_tab']['users'].'">
                      <i class="bi bi-people"></i>
                      &nbsp;Users
                    </a>
                    </li>
                    <li>
                    <a href="/engoje/products/?action=product" class="nav-link text-white '.$_SESSION['active_tab']['products'].'">
                      <i class="bi bi-basket2"></i>
                      &nbsp;Products
                    </a>
                    </li>
                    <li>
                    <a href="/engoje/upload/" class="nav-link text-white '.$_SESSION['active_tab']['images'].'">
                      <i class="bi bi-images"></i>
                      &nbsp;Images
                    </a>
          
                </ul>
                <hr>
                <a class="dropdown-item" href="/engoje/accounts/index.php?action=logout">Sign out</a>
            </div>
        </main>';

        return $adminSideNav;
    }
    }
}



//  Build Admin Side Nav display
function buildMyAccountSideNav(){

  $name = '';

  // for logged in user
  if(isset($_SESSION['userData']) && $_SESSION['loggedin'] && $_SESSION['userData']['userLevel']==1){
      $name = $_SESSION['userData']['userFirstName'];


    // make sure $active_tab['users'] is set
    if(isset($_SESSION['my_active_tab'])){

        $adminSideNav = 
        '<main class="admin-dashboardnav">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white admin-nav" style="width: 280px;">
                <a href="/engoje/myaccount/?action=account" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                  <span class="fs-4">Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto"> 
                    <li class="nav-item">
                      <a href="/engoje/orders/?action=orders" class="nav-link text-white '.$_SESSION['my_active_tab']['orders'].'">
                        <i class="bi bi-truck"></i>
                        &nbsp;Orders
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/engoje/returns/?action=returns" class="nav-link text-white '.$_SESSION['my_active_tab']['returns'].'">
                        <i class="bi bi-truck-flatbed"></i>
                        &nbsp;Returns
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/engoje/reviews/?action=reviews" class="nav-link text-white '.$_SESSION['my_active_tab']['reviews'].'">
                        <i class="bi bi-megaphone"></i>
                        &nbsp;Reveiws
                      </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                      <a href="/engoje/accounts/?action=security" class="nav-link text-white '.$_SESSION['my_active_tab']['security'].'">
                        <i class="bi bi-shield-lock"></i>
                        &nbsp;security
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/engoje/upload/" class="nav-link text-white '.$_SESSION['my_active_tab']['addresses'].'">
                        <i class="bi bi-pin-map"></i>
                        &nbsp;Addresses
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item" href="/engoje/accounts/index.php?action=logout">
                        <i class="bi bi-person"></i>
                        &nbsp;Sign out
                      </a>
                    </li>
                  </ul>
            </div>
        </main>';

        return $adminSideNav;
    }
  } 
  }