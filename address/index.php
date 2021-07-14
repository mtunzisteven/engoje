



// Access adddress update form
        case 'new-address':

            $addressName = filter_input(INPUT_POST, 'addressName', FILTER_SANITIZE_STRING); 
            $addressNumber = filter_input(INPUT_POST, 'addressNumber', FILTER_SANITIZE_NUMBER_INT);
            $addressEmail = filter_input(INPUT_POST, 'addressEmail', FILTER_SANITIZE_STRING); 
            $addressLineOne = filter_input(INPUT_POST, 'addressLineOne', FILTER_SANITIZE_STRING); 
            $addressLineTwo = filter_input(INPUT_POST, 'addressLineTwo', FILTER_SANITIZE_STRING);
            $addressCity = filter_input(INPUT_POST, 'addressCity', FILTER_SANITIZE_STRING);
            $addressZipCode = filter_input(INPUT_POST, 'addressZipCode', FILTER_SANITIZE_STRING);
            $addressType = filter_input(INPUT_POST, 'addressType', FILTER_SANITIZE_NUMBER_INT);

            if(!empty($addressName) && !empty($addressNumber) && !empty($addressEmail) && !empty($addressLineOne) 
                && !empty($addressLineTwo) && !empty($addressCity) && !empty($addressZipCode) && !empty($addressType)){
                
                // Add billing address
                $newAddress = addAddress($addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['updatinguserId']);

                // Set shipping addressType
                $addressType =$addressType+1;

                // Add shipping address
                $newAddress = addAddress($addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['updatinguserId']);

            
                // carry on if an address exists for the user
                if($newAddress){

                    // Get the new addresses you added
                    $addresses = getAddress($_SESSION['updatinguserId']);
                
                    // Set true if because there are addresses found in the database
                    $addressFound = true;

                    // Build Address display
                    $addressSideDisplay = buildAddresses($addresses, $addressFound);

                    $message = "<p class='notice detail-span-bold center'>Success, we added the address successfully.</p>";
                }else{
                    // Empty placeholder values, but values were added by user
                    $message = "<p class='notice detail-span-bold'>Error, we couldn't add the address.</p>";
    
                }

            }else{
                $message = "<p class='notice detail-span-bold'>Error! All address details need to be filled</p>";
                include '../view/admin.php';
                exit;
            }

            include '../view/address.php';
