<?php 

    $pageName="Home";
    $pageDescription="We provide you and your business tax consulting and professional tax consultancy services.";
    $pageShortSummary="We are your accounting services";
    $heading="Welcome to the home of Professional Accountants & Tax Consultants"

?><!DOCTYPE html>
<html lang="en-us">

    <?php include 'snippets/head.php'; ?>

    <body>
        <main class="content bg-white">            

            <?php include 'snippets/navigation.php'; ?>
            <?php include 'snippets/homehero.php'; ?>

            <div class="row mt-5 mb-3 px-sm-2 py-5 px-lg-2 px-xl-0 box-content">
                <div class="col-sm-12 col-lg-3 pb-md-0 pb-lg-0 pb-sm-5">
                    <div class="">
                        <img src="../images/accounting-team.jpg" class="card-img-top border-none" alt="Accountant">
                        <div class="d-grid gap-2">
                            <a href="/about" class="btn btn-primary">About Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-9 ps-4 pt-sm-5 pt-lg-0">
                    <div class="mt-5 mt-sm-1 mt-md-0">
                        <h2 class="text-primary display-2 fs-1">Count on us for reliable accounting solutions.</h2>
                        <p class="text-grey fs-6">
                        Nosihe Consulting and Advisory Services is a leading business consulting firm in South Africa. We specialize in providing customized solutions to help businesses of all sizes and industries achieve their goals.
                        </p>                        
                        <p class="text-grey fs-6">
                        At Nosihe Consulting and Advisory Services, we understand the challenges that businesses face in today's fast-paced and ever-changing environment. That's why we offer a wide range of consulting services to help businesses adapt and thrive in a competitive marketplace.                        
                        </p>       
                        <p class="text-grey fs-6">
                        Whether you need help with business strategy, financial management, marketing and branding, or organizational development, our team of experienced consultants is here to help. We work closely with our clients to understand their unique needs and develop solutions that are tailored to their specific situation.                        
                        </p>                    
                    </div>
                </div>
            </div>

            <div class="py-5 px-sm-5 px-lg-2 px-xl-0 bg-info">
                <div class="row box-content px-3 py-3">
                    <h2 class="text-light display-2 fs-1 p-0 text-center text-md-start">We Make it Easy for You and Your Business.</h2>
                </div>
                <div class="row box-content px-3 text-center text-md-start">

                    <div class="col-sm-12 col-md-3 bg-info p-0">
                        <div class="cardcard bg-info text-light border-0">
                            <div class="card-body">
                                <h5 class="card-title">Accounting</h5>
                                <p class="card-text">
                                We take the hassle out of your accounting.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 bg-info p-0">
                        <div class="card bg-info text-light border-0">
                            <div class="card-body">
                                <h5 class="card-title">Tax</h5>
                                <p class="card-text">
                                We make sure you never get caught off-gaurd by tax deadlines.
                                </p>                        
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 bg-info p-0">
                        <div class="cardcard bg-info text-light border-0">
                        <div class="card-body">
                                <h5 class="card-title">Bookkeeping</h5>
                                <p class="card-text">
                                We keep your books in order so your business can be successful.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 bg-info p-0">
                        <div class="card bg-info text-light border-0">
                            <div class="card-body ps-md-0">
                                <h5 class="card-title">You can count on us!</h5>
                                <a href="/contact" class="btn btn-light btn-lg">Contact us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-5 px-sm-5 px-lg-2 px-xl-0">
                <div class="row box-content px-3 py-3">
                    <h2 class="text-info display-2 fs-1 p-0 text-center">Professional Affiliation</h2>
                </div>
                <div class="row box-content px-3 text-center">
                  
                    <div class="col-sm-12 col-md-4 p-0">
                        <div class="card text-dark border-0">
                            <div class="card-body ps-md-0">
                                <img src="../images/cma.png" class="card-img-top border-none thumbs" alt="Accountant">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 p-0">
                        <div class="card text-dark border-0">
                            <div class="card-body ps-md-0">
                                <img src="../images/SAIPA.png" class="card-img-top border-none thumbs" alt="Accountant">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 p-0">
                        <div class="card text-dark border-0">
                            <div class="card-body ps-md-0">
                                <img src="../images/SARS.jpg" class="card-img-top border-none thumbs" alt="Accountant">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'snippets/footer.php'; ?>
        </main>
    </body>
</html>