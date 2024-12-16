<?php 
        session_start();

        //echo $_SESSION['error-message'];exit;

    $pageName="Contact";
    $pageDescription="We provide you and your business tax consulting and professional tax consultancy services.";
    $pageShortSummary="Get in touch with us";
    $heading="Contact Us"

?><!DOCTYPE html>
<html lang="en-us">

    <?php include '../snippets/head.php'; ?>

    <body>
        <main class="content bg-white">            

            <?php include  '../snippets/navigation.php'; ?>
            <?php include  '../snippets/hero.php'; ?>

            <div class="py-5 px-sm-5 px-lg-2 px-xl-0">
                <div class="row box-content px-3 py-3 text-center box-content">
                    <h2 class="text-primary display-2 fs-1 p-0 text-center">Get in Touch!</h2>
                    There are several ways to get in touch with us, including phone, email, and online form submission. Whatever your preferred method of communication, our team is ready to assist you with any questions or concerns you may have. We pride ourselves on our responsiveness and commitment to excellent customer service, and we look forward to hearing from you soon.                
                </div>
            </div>

            <div class="row mx-auto box-content bg-info text-light py-5 mb-5"> 
                
                <div class="col-sm-10 col-lg-4 mx-auto p-5 pt-0">
                    <h3 class="mb-0">Our Operating Hours:</h3>
                    <p class="mb-0">Monday - Thursday: 7:30AM - 4:30PM</p>                        
                    <p class="mb-0">Friday: 7:30AM - 3PM</p>                        
                    <p class="mb-0">Saturday and Sunday: Closed</p>    
                    <hr class="w-50 mb-1 mt-2"/>     

                    <div class="row align-middle mt-2">
                        <div class="col-2 pe-0">
                        <i class="bi bi-telephone-fill fs-5" aria-hidden="true"></i>
                        </div>
                        <div class="col-10 ps-0">
                            <div class=" ps-0">031 003 5117</div>
                        </div>  
                    </div>
                    <div class="row align-middle mt-2">
                        <div class="col-2 pe-0">
                            <i class="bi bi-phone-fill fs-5" aria-hidden="true"></i> 
                        </div>
                        <div class="col-10">
                            <div class="row ps-0">
                                <div class="col-12 text-start ps-0">060 668 8307</div>
                                <div class="col-12 text-start ps-0">064 559 7335</div>
                            </div>  
                        </div>  
                    </div>
                    <div class="row align-middle mt-2">
                        <div class="col-2 pe-0">
                            <i class="bi bi-envelope-fill fs-5" aria-hidden="true"></i>
                        </div>
                        <div class="col-10 ps-0">
                            <div class=" ps-0">info@nosihe.co.za</div>
                        </div>  
                    </div>
                    <div class="row align-middle mt-2">
                        <div class="col-2 pe-0">
                            <i class="fs-5 bi bi-pin-map-fill"></i>
                        </div>
                        <div class="col-10">
                            <div class="row ps-0">
                                <div class="col-12 text-start ps-0">70 Buckingham Terrace</div>
                                <div class="col-12 text-start ps-0">1st Floor Pharos Court</div>
                                <div class="col-12 text-start ps-0">Westville, 3630</div>
                            </div>  
                        </div>  
                    </div>
                </div> 

                <form class="contact-form col-sm-10 col-lg-6 mx-auto p-5 pt-0" role=" form" method="post" action="/" id="form">
                    <h2 class="h3 mb-3 fw-normal">Send us a message</h2>

                    <div class="my-2" style="height: 50px;">
                        <label class="p-0">Full Name</label>
                        <input class="form-control" style="height: 30px;" type="text" name="name" id="name"  value="<?php if(isset($_SESSION['name']) && !$_SESSION['sent']){echo $_SESSION['name'];} ?>" required>         
                    </div>
                    <div class="my-2" style="height: 50px;">
                        <label class="p-0">Contact Number</label>
                        <input class="form-control" style="height: 30px;" type="tel" name="phone" id="phone" value="<?php if(isset($_SESSION['phone']) && !$_SESSION['sent']){echo $_SESSION['phone'];} ?>" required>
                    </div>
                    <div class="my-2" style="height: 50px;">
                        <label class="p-0">Email</label>
                        <input class="form-control" style="height: 30px;" type="email" name="email" id="email" value="<?php if(isset($_SESSION['email']) && !$_SESSION['sent']){echo $_SESSION['email'];} ?>" required>
                    </div>
                    <div class="mt-2" style="height: 150px;">
                        <label class="p-0 ms-1">Message</label>
                        <textarea class="form-control p-0" style="height: 150px;" name="message" id="message" ><?php if(isset($_SESSION['message']) && !$_SESSION['sent']){echo $_SESSION['message'];} ?></textarea>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>

                    <input type="hidden" name="action" value="contactForm" >
                    <?php if(isset($_SESSION['status-message'])){echo $_SESSION['status-message']; $_SESSION=[];} ?>


                </form>
            </div>



            <?php include '../snippets/footer.php'; ?>
        </main>
    </body>
</html>
