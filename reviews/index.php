<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the reviews controller for the site
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the function file
require_once '../library/functions.php';
// Get the accounts model for use as needed
require_once '../model/accounts-model.php';
// Get the main model for use as needed
require_once '../model/main-model.php';
// Get the reviews model for use as needed
require_once '../model/reviews-model.php';

$classifications = getClassifications();

// active tab array
$_SESSION['active_tab'] = [
    'account'=>'',
    'users'=>'active',
    'products'=>'',
    'taxonomy' => '', 
    'images'=>'',
    'orders'=>'',
    'reviews'=>'',
    'promotions'=>''
];


// Get and sanitize action value
$action = filter_input(INPUT_POST, 'action');
if($action==NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch($action){

    // Add a new review
    case 'addReview':

        // reviewText will be actual review entered by the logged in client
        // invId to be used to make sure the review is for the specific item/product only
        // userId is to ensure that the review is assigned to the specific user.
        $reviewText = filter_input(INPUT_POST, 'reviewText',FILTER_SANITIZE_STRING);
        $productId = filter_input(INPUT_POST, 'productId',FILTER_SANITIZE_NUMBER_INT);
        $userId = filter_input(INPUT_POST, 'userId',FILTER_SANITIZE_NUMBER_INT);

        // If any of the three key details are missing, we can't add review
        if(!empty($reviewText || $productId || $ $userId)){

            // Create date in mySQL format, with time. This aids in ordering by post date.
            $reviewDate = date('Y-m-d H:i:s');

            // USe the inputs and the time to add the review using a review-model function.
            $addReview = addReviews($userId, $productId, $reviewText, $reviewDate);

            // If review successfully added, return to the vehicle information page
            if($addReview){

                // Success message for user
                $message = '<p class=reviews-notice>Success! Your review was added successfully.</p>';

                // Get reviews for the specific user item(car)
                $reviews = getClientReviews($userId);
                
                // Get the reviews html from functions
                $customerReviews = customerReviews($reviews);

                // Send client to admin page where they'll see remaining reviews plus the success message.
                include "../view/admin.php";
            }

        }else{

            // Error message for user and send user back to same page.
            $message = "<p class=reviews-notice>Error! There was a problem adding your review. Please make sure you added all the required information.</p>";
            include "../view/orders.php";

        }

        break;

    // Get specific review usinng reviewId
    case 'getUpdateReview':

        // Get used instead of Post. This was information received from a link, not a form.
        $reviewId = filter_input(INPUT_GET, 'reviewId',FILTER_SANITIZE_NUMBER_INT);

        // Fetch the review to update
        $reviewUpdate = getUpdateReview($reviewId);
        $_SESSION['reviewTextUpdate'] = $reviewUpdate['reviewText'];
        
        include "../view/review-update.php";
        break;

    // Using the review fetched above, update will be carried out here.
    case 'updateReview': 

        // reviewText needed in updating the text from the model.
        // reviewId needed to pull up the specific review to update.
        // clientId required to pull up the reviews for the specific client and display 
        // them using customerReviews function from functions.
        $reviewText = filter_input(INPUT_POST, 'reviewText',FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_POST, 'reviewId',FILTER_SANITIZE_NUMBER_INT);
        $userId = filter_input(INPUT_POST, 'userId',FILTER_SANITIZE_NUMBER_INT);

        if(empty($reviewText)){

            $message = '<p class=reviews-notice>Error! Your review was empty and could not updated successfully.</p>';

            include "../view/review-update.php";
            exit;
        }

        // Use review-model function to update review
        $updatedReview = updateReview($reviewId, $reviewText);

        // Get the client's reviews
        $reviews = getClientReviews($userId);

        // Get the reviews html from functions
        $customerReviews = customerReviews($reviews);

        // If update Successfully carried out 1 will be returned, otherwise, false.
        if($updatedReview){

            $message = '<p class=reviews-notice>Success! Your review was updated.</p>';

            include "../view/admin.php";

        }else{
            $message = '<p class=reviews-notice>Error! No changes were made to the review and the review could not updated successfully.</p>';

            include "../view/review-update.php";
            exit;
        }

        break;

    case 'deleteRequest':

        // Get used instead of Post. This was information received from a link, not a form.
        $clientId = filter_input(INPUT_GET, 'userId',FILTER_SANITIZE_NUMBER_INT);

        //echo $clientId; exit;

        // Fetch the review to delete
        $deleteReview = getClientReviews($clientId);

        //echo var_dump($deleteReview); exit;

        //echo $deleteReview[0]['reviewId']; exit;
        
        include "../view/review-delete.php";
        break;

    // Deleting a specific review
    case 'delete':

        // reviewId needed to get the specific review that will be deleted 
        // clientId needed to get reviews for the specific client
        $reviewId = filter_input(INPUT_POST, 'reviewId',FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'userId',FILTER_SANITIZE_NUMBER_INT);


        // Get the users reviews
        $reviews = getClientReviews($clientId);

        // Delete the review 
        $deleteReview = deleteReview($reviewId);

        // If the review was deleted, 1 must be returned for 1 row changed. 1=true, 0=false.
        if($deleteReview){

            // Get the users updated reviews
            $reviews = getClientReviews($clientId);

            // Get the reviews html from functions
            $customerReviews = customerReviews($reviews);

            $message = '<p class=reviews-notice>Success! Your review was deleted successfully.</p>';
        }else{
            $message = '<p class=reviews-notice>Error! The was a problem deleting your review. Please try again.</p>';
        }
        
        include "../view/admin.php";

        break;

    default:
    
        // Logged in users go to admin page otherwise, users not logged in go to home page
        if(isset($_SESSION['loggedin'])){

            include "../view/admin.php";
        }else{
            include "../view/home.php";
        }
        
        break;
}

