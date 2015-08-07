# pmAuthNetClass
**An Authorize.Net Payment Authorization Class**

*http://PurpleMonkeyPower.com*

 This class allows for connection with Authorize.Net's Advance Integration Method (AIM) API
 More information about AIM can be found at http://developer.authorize.net/api/aim/
  
 Authorize.Net AIM API Version: 3.1


pmAuthNetClass.php is the class file you will require for use with your application
test.php is an example usage of this class to give you an idea of how to incorporate it into your application


## Requirements
- PHP 5.3+ *(>=5.3.10 recommended)*
- cURL PHP Extension
- An Authorize.Net Merchant Account or Sandbox Account. You can get a 
	free sandbox account at http://developer.authorize.net/sandbox/


## Authentication
To authenticate with the Authorize.Net API you will need to retrieve your API Login ID and Transaction Key from the Merchant Interface (*https://account.authorize.net/*).  You can find these details in the Settings section.
If you need a sandbox account you can sign up for one really easily *https://developer.authorize.net/sandbox/*.

Once you have your keys simply plug them into the appropriate variables as per the samples below.

````php
define("AUTHORIZENET_API_LOGIN_ID", "xxxxxxxxxx");  // replace xxxxxxxxxx with your Authorize.Net API Login ID
define("AUTHORIZENET_TRANSACTION_KEY", "xxxxxxxxxxxxxxxx");  // replace xxxxxxxxxxxxxxxx with your Authorize.net API Transaction Key
````

## Test Mode
To enable test mode set the following variable to true as per the sample below.

````php
define("AUTHORIZENET_SANDBOX", true);  // True = use Authorize.Net's sandbox url (Testing) or False = use Authorize.Net's live url
````


## USAGE
 ````php 
  Reference the class
  $sale = new pmAuthnet(AUTHORIZENET_API_LOGIN_ID, AUTHORIZENET_TRANSACTION_KEY, AUTHORIZENET_SANDBOX);
  
  Setup Tranasaction
  $sale->setTransaction($cardnum, $expiration, $amount, $cvv = null, $invoice = null, $tax = null);
  
  Set Parameters  - See http://developer.authorize.net/api/aim/ for list of accepted parameters
  $sale->setParameter("x_param_name", 'value');
  
  Process Transaction
  $sale->process();
  
  Check Responses
  $sale->isApproved();           // Check to see if approved
  $sale->isDeclined();           // Check to see if declined
  $sale->isError();              // Check to see if error
  
  Get Approval Info
  $sale->getAuthCode();          // Returns Authorization Code
  $sale->getAVSResponse();       // Returns AVS Response (address verification)
  $sale->getCVVResponse();       // Returns CVV Response (card verification)
  $sale->getTransactionID();     // Returns Transasction ID
  
  Get Response Messages
  ie: $sale->getResponseText     // Message
  ie: $sale->getResponseSubCode  // Returned Code
```
 

## Example
 ```php   
  try {
        $cardnum = '4007000000027';
        $expiration = '12/15';
        $amount = '19.99';
        $sale = new pmAuthnet(AUTHORIZENET_API_LOGIN_ID, AUTHORIZENET_TRANSACTION_KEY, AUTHORIZENET_SANDBOX);
        $sale->setTransaction($cardnum, $expiration, $amount);
        $sale->process();
 
        if ($sale->isApproved()){
            echo "Sale was approved \n";
            echo "Approval Code: " . $sale->getAuthCode() . "\n";
            echo "AVS Result: " . $sale->getAVSResponse() . "\n";
            echo "CVV Result: " . $sale->getCVVResponse() . "\n";
            echo "Transaction ID: " . $sale->getTransactionID() . "\n";
        } else if ($sale->isDeclined()){
            echo "Sale was declined \n";
            echo "Reason: " . $sale->getResponseText() . "\n";
        } else if ($sale->isError()){
            echo "Error Processing \n";
            echo "Error Number: " . $sale->getResponseSubCode() . "\n";
            echo "Error Message: " . $sale->getResponseText() . "\n";
            echo "Full Error Message: " . $sale->getResponseMessage() . "\n";
        }
    } catch (pmAuthnetException $e) {
        echo "There was an error processing the transaction. Here is the error message: \n";
        echo $e->__toString();
    } 
```  