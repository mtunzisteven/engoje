import{plisten} from "./addtocart.js";
import{wlisten} from "./addtowishlist.js";


let addToCart = document.querySelector('#add-to-cart-button'); 
let mcartCount = document.querySelector('#mobile-cart-count');
let addToCartResponse = document.querySelector('#add-to-cart-response');
let galleryImages = document.querySelectorAll('.product-gallery-image');

// ----------------------------------------------------------
//                 Add to Wishlist updating                  |
//-----------------------------------------------------------
let addToWishlist = document.querySelector('#add-to-wishlist-button');
let mwishlistCount = document.querySelector('#mobile-wishlist-count');

let urlWishlist = "http://localhost/zalisting/wishlist/index.php";

wlisten(addToWishlist, urlWishlist, product_entryId, wishlistCount, mwishlistCount, addToCartResponse, 'wishlistTotal', 'add-to-wishlist-response');

// ----------------------------------------------------------
//                   Add to cart updating                    |
//-----------------------------------------------------------

let urlCart = "http://localhost/zalisting/cart/index.php";

// add to cart event lister
plisten(addToCart, urlCart, product_entryId, cartQty, cartCount, mcartCount, addToCartResponse, 'cartTotal', 'add-to-cart-response');

// update main display image when the gallary image is clicked
for(let j = 0; j < galleryImages.length; j++){

    galleryImages[j].addEventListener('click', function(event){

        primaryImage.setAttribute('src', event.target.getAttribute('id'));        

    }, false);

}