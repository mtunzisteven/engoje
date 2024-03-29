import{plisten} from "./addto/addtocart.js";
import{wlisten} from "./addto/addtowishlist.js";


let addToCart = document.querySelector('#add-to-cart-button'); 
let mcartCount = document.querySelector('#mobile-cart-count');
var cartCounter = document.querySelector('#cart-count');
let addToCartResponse = document.querySelector('#add-to-cart-response');
let galleryImages = document.querySelectorAll('.product-gallery-image');

// ----------------------------------------------------------
//                 Add to Wishlist updating                  |
//-----------------------------------------------------------
let addToWishlist = document.querySelector('#add-to-wishlist-button');
var wishlistCounter = document.querySelector('#wishlist-count');
let mwishlistCount = document.querySelector('#mobile-wishlist-count');

let urlWishlist = "https://engoje.co.za/wishlist/index.php";

wlisten(addToWishlist, urlWishlist, product_entryId, wishlistCounter, mwishlistCount, addToCartResponse, 'wishlistTotal', 'add-to-wishlist-response');

// ----------------------------------------------------------
//                   Add to cart updating                    |
//-----------------------------------------------------------

let urlCart = "https://engoje.co.za/cart/index.php";

if(addToCart != null){ // works only for logged in users

    // add to cart event lister
    plisten(addToCart, urlCart, product_entryId, cartQty, cartCounter, mcartCount, addToCartResponse, 'cartTotal', 'add-to-cart-response');
}

// update main display image when the gallary image is clicked
for(let j = 0; j < galleryImages.length; j++){

    galleryImages[j].addEventListener('click', function(event){

        primaryImage.setAttribute('src', event.target.getAttribute('id'));        

    }, false);

}