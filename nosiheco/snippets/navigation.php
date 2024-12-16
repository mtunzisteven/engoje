<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-white">
  <div class="container-fluid box-content">
    <a class="navbar-brand" href="/">
        <img src=" /images/logo.jpg" alt="logo image" width="350" >
    </a>
    <button class="navbar-toggler my-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item px-3">
          <a class="nav-link text-center fw-bold <?php if($pageName=="Home"){echo 'text-primary';}else{echo 'text-secondary';} ?>" href="/">Home</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link text-center fw-bold <?php if($pageName=="About"){echo 'text-primary';}else{echo 'text-secondary';} ?>" href="/about">About</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link text-center fw-bold <?php if($pageName=="Services"){echo 'text-primary';}else{echo 'text-secondary';} ?>" href="/services">Services</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link text-center fw-bold <?php if($pageName=="Contact"){echo 'text-primary';}else{echo 'text-secondary';} ?>" href="/contact">Contact Us</a>
        </li>
      </ul>
    </div>
  </div>
</nav>