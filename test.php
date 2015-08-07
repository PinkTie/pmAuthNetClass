<?php

/** 
 * pmAuthNetClass
 * An Authorize.Net Payment Authorization Class
 * http://www.PurpleMonkeyPower.com
 *  
 * Copyright (C) 2015 Purple Monkey Studio, LLC
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.md
 * Redistributions of files must retain the above copyright notice
 * 
 * @copyright Purple Monkey Studio, LLC
 * @link http://www.purplemonkeypower.com
 * @author Kevin Fairbanks <kevin@kevinfairbanks.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 1.0
 */

require_once 'pmAuthNetClass.php';

define("AUTHORIZENET_API_LOGIN_ID", "xxxxxxxxxx");  // replace xxxxxxxxxx with your Authorize.Net API Login ID
define("AUTHORIZENET_TRANSACTION_KEY", "xxxxxxxxxxxxxxxx");  // replace xxxxxxxxxxxxxxxx with your Authorize.net API Transaction Key
define("AUTHORIZENET_SANDBOX", true);  // True = use Authorize.Net's sandbox url (Testing) or False = use Authorize.Net's live url

 try {
    $cardnum = '4007000000027';
    $expiration = '12/15';
    $amount = '19.99';
    $sale = new QAuthnet(AUTHORIZENET_API_LOGIN_ID, AUTHORIZENET_TRANSACTION_KEY, AUTHORIZENET_SANDBOX);
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
} catch (QAuthnetException $e) {
    echo "There was an error processing the transaction. Here is the error message: \n";
    echo $e->__toString();
} 

