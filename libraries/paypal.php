<?php
class LB_PAYPAL{

	public $PROXY_HOST = '127.0.0.1';
	public $PROXY_PORT = '808';
	
	public $API_UserName = "stevenmiller_api1.divorceez.com";
	public $API_Password = "CHCUASB5UUNMS45K";
	public $API_Signature= "AQYylE7vTKlfeZuxtKYPo18bYPgWAGJX2eTZq7SZEOFtU.iBMyeLTrIZ";
	public $API_Endpoint = "";
	public $PAYPAL_URL = "";
	
	public $USE_PROXY = false;
	public $version="64";
	public $sbn = "PP-ECWizard";

	public function __construct($sandbox = false)
	{
		if($sandbox == false)
		{
			$this->PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
			$this->API_UserName = "stevenmiller_api1.divorceez.com";
			$this->API_Password = "CHCUASB5UUNMS45K";
			$this->API_Signature= "AQYylE7vTKlfeZuxtKYPo18bYPgWAGJX2eTZq7SZEOFtU.iBMyeLTrIZ";
			$this->API_Endpoint = "https://api-3t.paypal.com/nvp";
		}
		else
		{
			$this->API_UserName = "mrhamm_1320428931_biz_api1.gmail.com";
			$this->API_Password = "1320428956";
			$this->API_Signature= "An5ns1Kso7MWUdW4ErQKJJJ4qi4-Adb2866hPRotwmoHBbcXsSuMYguv";
			$this->API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
			$this->PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
		}
	}

	function CallShortcutExpressCheckout( $paymentAmount, $detail, $currencyCodeType, $paymentType, $returnURL, $cancelURL)
	{
		$nvpstr="&AMT=". $paymentAmount;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&BILLINGAGREEMENTDESCRIPTION=".urlencode($detail);
		$nvpstr = $nvpstr . "&BILLINGTYPE=RecurringPayments";
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $currencyCodeType;

		$_SESSION["currencyCodeType"] = $currencyCodeType;
		$_SESSION["PaymentType"] = $paymentType;

		$resArray = $this->hash_call("SetExpressCheckout", $nvpstr);

		$ack = isset($resArray["ACK"]) ? strtoupper($resArray["ACK"]) : '';
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$token = urldecode($resArray["TOKEN"]);
			$_SESSION['TOKEN']=$token;
		}
		
	    return $resArray;
	}

	function CallMarkExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL,
									  $cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
									  $shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum
									) 
	{

		$nvpstr="&PAYMENTREQUEST_0_AMT=". $paymentAmount;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $currencyCodeType;
		$nvpstr = $nvpstr . "&ADDROVERRIDE=1";
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTONAME=" . $shipToName;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOSTREET=" . $shipToStreet;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOSTREET2=" . $shipToStreet2;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOCITY=" . $shipToCity;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOSTATE=" . $shipToState;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=" . $shipToCountryCode;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOZIP=" . $shipToZip;
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPTOPHONENUM=" . $phoneNum;
		
		$_SESSION["currencyCodeType"] = $currencyCodeType;	  
		$_SESSION["PaymentType"] = $paymentType;

	    $resArray=$this->hash_call("SetExpressCheckout", $nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$token = urldecode($resArray["TOKEN"]);
			$_SESSION['TOKEN']=$token;
		}
		   
	    return $resArray;
	}
	
	function GetShippingDetails( $token )
	{
	    $nvpstr="&TOKEN=" . $token;

	    $resArray=$this->hash_call("GetExpressCheckoutDetails",$nvpstr);
	    $ack = strtoupper($resArray["ACK"]);

		if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{	
			$_SESSION['payer_id'] =	$resArray['PAYERID'];
			$_SESSION['email'] =	$resArray['EMAIL'];
			$_SESSION['firstName'] = $resArray["FIRSTNAME"]; 
			$_SESSION['lastName'] = $resArray["LASTNAME"]; 
			$_SESSION['shipToName'] = $resArray["SHIPTONAME"]; 
			$_SESSION['shipToStreet'] = $resArray["SHIPTOSTREET"]; 
			$_SESSION['shipToCity'] = $resArray["SHIPTOCITY"];
			$_SESSION['shipToState'] = $resArray["SHIPTOSTATE"];
			$_SESSION['shipToZip'] = $resArray["SHIPTOZIP"];
			$_SESSION['shipToCountry'] = $resArray["SHIPTOCOUNTRYCODE"];
		} 
		return $resArray;
	}

	function ConfirmPayment( $FinalPaymentAmt )
	{

		//Format the other parameters that were stored in the session from the previous calls	
		$token 		= urlencode($_SESSION['TOKEN']);
		$paymentType 		= urlencode($_SESSION['PaymentType']);
		$currencyCodeType 	= urlencode($_SESSION['currencyCodeType']);
		$payerID 		= urlencode($_SESSION['payer_id']);

		$serverName 		= urlencode($_SERVER['SERVER_NAME']);

		$nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTACTION=' . $paymentType . '&AMT=' . $FinalPaymentAmt;
		$nvpstr .= '&CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName;
		$nvpstr.="&NOTIFYURL=".urlencode("http://leading-people.com/payment_notify");
		$resArray=$this->hash_call("DoExpressCheckoutPayment",$nvpstr);

		//$_SESSION['billing_agreemenet_id']	= $resArray["BILLINGAGREEMENTID"];
		$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}
	
	function CreateRecurringPaymentsProfile()
	{
		$token 		= urlencode($_SESSION['TOKEN']);
		$email 		= urlencode($_SESSION['email']);
		$shipToName		= urlencode($_SESSION['shipToName']);
		$shipToStreet		= urlencode($_SESSION['shipToStreet']);
		$shipToCity		= urlencode($_SESSION['shipToCity']);
		$shipToState		= urlencode($_SESSION['shipToState']);
		$shipToZip		= urlencode($_SESSION['shipToZip']);
		$shipToCountry	= urlencode($_SESSION['shipToCountry']);
	   
		$nvpstr="&TOKEN=".$token;
		#$nvpstr.="&EMAIL=".$email;
		$nvpstr.="&SHIPTONAME=".$shipToName;
		$nvpstr.="&SHIPTOSTREET=".$shipToStreet;
		$nvpstr.="&SHIPTOCITY=".$shipToCity;
		$nvpstr.="&SHIPTOSTATE=".$shipToState;
		$nvpstr.="&SHIPTOZIP=".$shipToZip;
		$nvpstr.="&SHIPTOCOUNTRY=".$shipToCountry;
		$nvpstr.="&PROFILESTARTDATE=".urlencode(date("Y-m-d\TH:i:s", strtotime("+".intval($_SESSION['attempt']['duration'])." months")));
		$nvpstr.="&DESC=".urlencode($_SESSION['attempt']['detail']);
		$nvpstr.="&BILLINGPERIOD=Year";
		$nvpstr.="&BILLINGFREQUENCY=".(intval($_SESSION['attempt']['duration'])/12);
		$nvpstr.="&AMT=".$_SESSION['attempt']['amount'];
		$nvpstr.="&CURRENCYCODE=USD";
		$nvpstr.="&NOTIFYURL=".urlencode("http://leading-people.com/payment_notify");
		$nvpstr.="&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];
		

		$resArray=$this->hash_call("CreateRecurringPaymentsProfile",$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		return $resArray;
	}


	function DirectPayment( $paymentType, $paymentAmount, $creditCardType, $creditCardNumber,
							$expDate, $cvv2, $firstName, $lastName, $street, $city, $state, $zip, 
							$countryCode, $currencyCode )
	{
		$nvpstr = "&AMT=" . $paymentAmount;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $currencyCode;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&CREDITCARDTYPE=" . $creditCardType;
		$nvpstr = $nvpstr . "&ACCT=" . $creditCardNumber;
		$nvpstr = $nvpstr . "&EXPDATE=" . $expDate;
		$nvpstr = $nvpstr . "&CVV2=" . $cvv2;
		$nvpstr = $nvpstr . "&FIRSTNAME=" . $firstName;
		$nvpstr = $nvpstr . "&LASTNAME=" . $lastName;
		$nvpstr = $nvpstr . "&STREET=" . $street;
		$nvpstr = $nvpstr . "&CITY=" . $city;
		$nvpstr = $nvpstr . "&STATE=" . $state;
		$nvpstr = $nvpstr . "&COUNTRYCODE=" . $countryCode;
		$nvpstr = $nvpstr . "&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];

		$resArray=$this->hash_call("DoDirectPayment", $nvpstr);

		return $resArray;
	}

	function hash_call($methodName,$nvpStr)
	{

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		if($this->USE_PROXY)
			curl_setopt ($ch, CURLOPT_PROXY, $this->PROXY_HOST. ":" . $this->PROXY_PORT);

		$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($this->version) . "&PWD=" . urlencode($this->API_Password) . "&USER=" . urlencode($this->API_UserName) . "&SIGNATURE=" . urlencode($this->API_Signature) . $nvpStr ."&BUTTONSOURCE=" . urlencode($this->sbn);

		//err($nvpreq);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

		$response = curl_exec($ch);

		$nvpReqArray=$this->deformatNVP($nvpreq);
		$nvpResArray=$this->deformatNVP($response);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) 
		{
			// moving to display page to display curl errors
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);

			  //Execute the Error handling module to display errors. 
		} 
		else 
		{
			 //closing the curl
		  	curl_close($ch);
		}

		return $nvpResArray;
	}

	function RedirectToPayPal ( $token )
	{
		$payPalURL = $this->PAYPAL_URL . $token;
		header("Location: ".$payPalURL);
		die;
	}

	
	function deformatNVP($nvpstr)
	{
		$intial=0;
	 	$nvpArray = array();

		while(strlen($nvpstr))
		{
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}
}
?>
