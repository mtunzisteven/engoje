import{listen} from "./addtocart.js";

let addToCart = document.querySelector('#add-to-cart-button'); 
let mcartCount = document.querySelector('#mobile-cart-count');
let addToCartRespose = document.querySelector('#add-to-cart-response');
let galleryImages = document.querySelectorAll('.product-gallery-image');

// ----------------------------------------------------------
//                 Add to Wishlist updating                  |
//-----------------------------------------------------------
let addToWishlist = document.querySelector('#add-to-wishlist-button');
var mwishlistCount = document.querySelector('#mobile-wishlist-count');

let urlCart = "http://localhost/zalisting/cart/index.php";

listen(addToCart, urlCart, product_entryId, cartQty, cartCount, mcartCount, addToCartRespose, 'cartTotal', 'add-to-cart-response');

// update main display image when the gallary image is clicked
for(let j = 0; j < galleryImages.length; j++){

    galleryImages[j].addEventListener('click', function(event){

        primaryImage.setAttribute('src', event.target.getAttribute('id'));        

    }, false);

}