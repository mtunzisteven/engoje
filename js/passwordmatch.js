
// variables defined
let password = document.querySelector("#password");
let password2 = document.querySelector("#password2");
let passwordConfirmDiv = document.querySelector("#match-password-div");
let submitButton = document.querySelector('#regbtn');

// When clicking input 2
password2.addEventListener('click', function(){

    // clear div message
    passwordConfirmDiv.innerHTML = "";

    // enable button
    submitButton.disabled = false; 


}, false);

// when moving away from input 2
password2.addEventListener('blur', processEvent, false);

// when clicking submit button
submitButton.addEventListener('click', processEvent, false);

function processEvent(){

    if(password.value !== password2.value){
        
        // disable button
        submitButton.disabled = true; 
        
        // Send response about matching passwords
        passwordConfirmDiv.innerHTML = "Passwords do not match! Please try again.";

    }else{

        return;

    }
}