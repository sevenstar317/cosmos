<?php

namespace App\Models;

use Artisaninweb\SoapWrapper\Extension\SoapService;
use SimpleXMLElement;
use Auth;
use Session;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use    GuzzleHttp\Client;

class Soap extends SoapService
{

	/**
	 * @var string
	 */
	protected $name = 'test';

	protected $API_username = 'lcadmin';
	protected $API_password = 'Ducati101#!948'; // old Live48CT35@
	/**
	 * @var string
	 */
	protected $wsdl = 'https://secure.livecosmos.com/webservices/api.asmx?wsdl';

	/**
	 * @var boolean
	 */
	protected $trace = true;

	/**
	 * Get all the available functions
	 *
	 * @return mixed
	 */
	public function functions()
	{
		return $this->getFunctions();
	}

	protected function checkDomain(){
		if ($_SERVER['HTTP_HOST'] == 'm.livecosmos.com') {
			$AID =3;
		} else if ($_SERVER['HTTP_HOST'] == 'livecosmos.com') {
			$AID = 1;
		}else{
			$AID = 2;
		}
		return $AID;
	}

	protected function parseXMLToJson($xml)
	{
		$client = new Client();
		$request = new GuzzleRequest('POST', $this->wsdl,['Content-Type' => 'text/xml; charset=UTF8'], $xml);
		$response = $client->send($request);
		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response->getBody()->getContents());
		$xml = new SimpleXMLElement($response);
		$body = $xml->xpath('//soapBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE);
		return $array;

	}


	// Incomplete Lead
	public function createLead($request, $data)
	{
		$AID = $this->checkDomain();
		$TID = 1;
		$SID = '';

		if(Session::has('AID')){
			$AID = Session::get('AID');
		}
		if(Session::has('TID')){
			$TID = Session::get('TID');
		}
		if(Session::has('SID')){
			$SID = Session::get('SID');
		}

		$phone = isset($data['phone_number'])?$data['phone_number']:"";
		$xml ='
			<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
			  <soap12:Body>
			    <CreateLead xmlns="http://www.livecosmos.com//">
			      <API_username>'.$this->API_username.'</API_username>
			      <API_password>'.$this->API_password.'</API_password>
			      <MemberFirstName>'. $data['first_name'].'</MemberFirstName>
			      <MemberLastName>'.$data['last_name'].'</MemberLastName>
			      <MemberEmail>'.$data['email'].'</MemberEmail>
			      <MemberPassword>q1w2e3r4t5y6</MemberPassword>
			      <MemberIPAddress>'.$data['ip'].'</MemberIPAddress>
			      <AID>'.$AID.'</AID>
			      <SID>'.$SID.'</SID>
			      <TID>'.$TID.'</TID>
			      <PhoneNumber>'.$phone.'</PhoneNumber>
			    </CreateLead>
			  </soap12:Body>
			</soap12:Envelope>';

		//Log::debug($xml);

		$array = $this->parseXMLToJson($xml);

		if (isset($array['CreateLeadResponse']['CreateLeadResult'])) {
			if (isset($array['CreateLeadResponse']['CreateLeadResult']['Result']['ErrorMessage'])) {
				if (count($array['CreateLeadResponse']['CreateLeadResult']['Result']['ErrorMessage']) == 0) {
					return ['lead_id' => $array['CreateLeadResponse']['CreateLeadResult']['LeadID'], 'member_id' => $array['CreateLeadResponse']['CreateLeadResult']['MemberID']];
				} else {
					return ['error' => $array['CreateLeadResponse']['CreateLeadResult']['Result']['ErrorMessage']];
				}
			}
		}
	}

	// Process Lead
	public function processLead($data, $payment_data, $sku)
	{
		$AID = $this->checkDomain();
		$TID = 1;
		$SID = '';

		if(Session::has('AID')){
			$AID = Session::get('AID');
		}
		if(Session::has('TID')){
			$TID = Session::get('TID');
		}
		if(Session::has('SID')){
			$SID = Session::get('SID');
		}

		$pd = preg_replace('/\s+/', ' ',$payment_data['card_name']);

		$paymentYear = substr($payment_data['card_year'], -2);

		$paymentInfo = explode(' ', $pd);
		switch($sku){
			case '521622':
			case '521634':
				$orderType = 'minutes';
				$description = '5 Minute Package';
				$totalMinutes = '00:05:00';
			break;
			case '521635':
				$orderType = 'minutes';
				$description = '3 Minute Package';
				$totalMinutes = '00:03:00';
				break;
			case '521623':
				$orderType = 'minutes';
				$description = '10 Minute Package';
				$totalMinutes = '00:10:00';
				break;
			case '521624':
				$orderType = 'minutes';
				$description = '15 Minute Package';
				$totalMinutes = '00:15:00';
				break;
			case '521630':
				$orderType = 'natal';
				$description = 'Personal Map Report';
				$totalMinutes = '00:00:00';
				break;
			default:
				$orderType = 'N/A';
				$description = 'N/A';
				$totalMinutes = '00:00:00';
				break;
		}


		$pfname = isset($paymentInfo[0]) ? $paymentInfo[0] : '';
		$plname = isset($paymentInfo[1]) ? $paymentInfo[1] : '';

		$xml = '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
				  <soap12:Body>
				    <ProcessLead xmlns="http://www.livecosmos.com//">
				    <API_username>'.$this->API_username.'</API_username>
					<API_password>'.$this->API_password.'</API_password>
				      <LeadID>'.$data['lead_id'].'</LeadID>
				      <ATI_Order>
				        <ShippingInfo>
				          <FirstName>'.$data['first_name'].'</FirstName>
				          <LastName>'.$data['last_name'].'</LastName>
				          <Zip>'.trim($payment_data['zip']).'</Zip>
				          <Country>USA</Country>
				          <Email>'.$data['email'].'</Email>
				        </ShippingInfo>
				        <BillingInfo>
				          <BillingAddress>
				            <FirstName>'.$pfname.'</FirstName>
				            <LastName>'.$plname.'</LastName>
				            <Zip>'.trim($payment_data['zip']).'</Zip>
				            <Country>USA</Country>
				            <Email>'.$data['email'].'</Email>
				          </BillingAddress>
				          <CardNumber>'.trim($payment_data['card_number']).'</CardNumber>
				          <CVV>'.trim($payment_data['card_cvv']).'</CVV>
				          <ExpDate_MMYY>'.trim($payment_data['card_month'] . $paymentYear).'</ExpDate_MMYY>
				        </BillingInfo>
				        <CartItems>
				          <ATI_CartItem>
				            <ATI_Sku>'.$sku.'</ATI_Sku>
				            <qty>1</qty>
				          </ATI_CartItem>
				        </CartItems>
				      </ATI_Order>
				      <PreviewOnlyFlag>false</PreviewOnlyFlag>
				       <AID>'.$AID.'</AID>
						<SID>'.$SID.'</SID>
						<TID>'.$TID.'</TID>
				    </ProcessLead>
				  </soap12:Body>
				</soap12:Envelope>';


		Log::debug($xml);

		$array = $this->parseXMLToJson($xml);

		if (isset($array['ProcessLeadResponse']['ProcessLeadResult'])) {
			if (isset($array['ProcessLeadResponse']['ProcessLeadResult']['Result']['ErrorMessage'])) {
				if (count($array['ProcessLeadResponse']['ProcessLeadResult']['Result']['ErrorMessage']) == 0) {
					return ['order_id' => $array['ProcessLeadResponse']['ProcessLeadResult']['OrderID'],
							'member_id' => $array['ProcessLeadResponse']['ProcessLeadResult']['MemberID'],
							'total' => $array['ProcessLeadResponse']['ProcessLeadResult']['Total'],
							'subtotal' => $array['ProcessLeadResponse']['ProcessLeadResult']['SubTotal'],
							'type'=>$orderType,
							'totalMinutes'=>$totalMinutes,
							'description' => $description,
							'discount' => $array['ProcessLeadResponse']['ProcessLeadResult']['Discount']];
				} else {
					return ['error' => $array['ProcessLeadResponse']['ProcessLeadResult']['Result']['ErrorMessage']];
				}
			}
		}
	}

	// Process New Sale no working
	public function processNewSale($data, $payment_data, $sku)
	{
		$AID = $this->checkDomain();
		$TID = 1;
		$SID = '';

		if(Session::has('AID')){
			$AID = Session::get('AID');
		}
		if(Session::has('TID')){
			$TID = Session::get('TID');
		}
		if(Session::has('SID')){
			$SID = Session::get('SID');
		}

		$pd = preg_replace('/\s+/', ' ',$payment_data['card_name']);
		$paymentYear = substr($payment_data['card_year'],  -2);
		$paymentInfo = explode(' ', $pd);

		$this->call('ProcessNewSale', [[
				'LeadID' => $data['lead_id'],
				'API_username' => $this->API_username,
				'API_password' => $this->API_password,
				'ATI_Order' => [
						'ShippingInfo' => [
								'FirstName' => $data['first_name'],
								'LastName' => $data['last_name'],
								'Address1' =>  isset($data['address_1'])?$data['address_1']:'',
								'City' => $data['city'],
								'Zip' => $data['zip'],
								'Country' => 'USA',
								'Phone' => isset($data['phone_number'])?$data['phone_number']:'',
								'Email' => $data['email'],
								'State' => $data['state']
						],
						'BillingInfo' => [
								'BillingAddress' => [
										'FirstName' => isset($paymentInfo[0]) ? $paymentInfo[0] : ' ',
										'LastName' => isset($paymentInfo[1]) ? $paymentInfo[1] : ' ',
										'Address1' =>  isset($data['address_1'])?$data['address_1']:'',
										'City' => $data['city'],
										'Zip' => $payment_data['zip'],
										'Country' => 'USA',
										'Phone' => isset($data['phone_number'])?$data['phone_number']:'',
										'Email' => $data['email'],
										'State' => $data['state']
								],
								'CardType' => substr($payment_data['card_number'], 0,1) == '5' ? 'Mastercard' : 'Visa',
								'CardNumber' => trim($payment_data['card_number']),
								'CVV' => trim($payment_data['card_cvv']),
								'ExpDate_MMYY' => trim($payment_data['card_month'] . $paymentYear),
						],
						'CartItems' => [
								'ATI_CartItem' => [
										'ATI_Sku' => $sku,
										'qty' => 1
								]
						],
				],
				'PreviewOnlyFlag' => false,
				'MemberPassword' => $data['real_password'],
				'AID' => $AID,
				'TID' => $TID,
				'SID' => $SID,
				'MemberIPAddress'=>$data['ip']
		]]);

		$array = $this->parseXMLToJson();
		if (isset($array['ProcessNewSaleResponse']['ProcessNewSaleResult'])) {
			if (isset($array['ProcessNewSaleResponse']['ProcessNewSaleResult']['Result']['ErrorMessage'])) {
				if (count($array['ProcessNewSaleResponse']['ProcessNewSaleResult']['Result']['ErrorMessage']) == 0) {
					return ['order_id' => $array['ProcessNewSaleResponse']['ProcessNewSaleResult']['OrderID'], 'member_id' => $array['ProcessNewSaleResponse']['ProcessNewSaleResult']['MemberID']];
				} else {
					return ['error' => $array['ProcessNewSaleResponse']['ProcessNewSaleResult']['Result']['ErrorMessage']];
				}
			}
		}
	}

	// process Order Existing Account
	public function processOrderExistingAccount($data, $payment_data, $sku)
	{
		$AID = $this->checkDomain();
		$TID = 1;
		$SID = '';

		if(Session::has('AID')){
			$AID = Session::get('AID');
		}
		if(Session::has('TID')){
			$TID = Session::get('TID');
		}
		if(Session::has('SID')){
			$SID = Session::get('SID');
		}


		switch($sku){
			case '521622':
			case '521634':
			$orderType = 'minutes';
				$description = '5 Minute Package';
				$totalMinutes = '00:05:00';
				break;
			case '521635':
				$orderType = 'minutes';
				$description = '3 Minute Package';
				$totalMinutes = '00:03:00';
				break;
			case '521623':
				$orderType = 'minutes';
				$description = '10 Minute Package';
				$totalMinutes = '00:10:00';
				break;
			case '521624':
				$orderType = 'minutes';
				$description = '15 Minute Package';
				$totalMinutes = '00:15:00';
				break;
			case '521632':
				$orderType = 'transit3';
				$description = 'Future Forecast Report';
				$totalMinutes = '00:00:00';
				break;
			case '521630':
				$orderType = 'natal';
				$description = 'Personal Map Report';
				$totalMinutes = '00:00:00';
				break;
			case '521631':
				$orderType = 'relationship';
				$description = 'Romantic Report';
				$totalMinutes = '00:00:00';
				break;
			case '521628':
				$orderType = 'downloadReport';
				$description = 'Download Report';
				$totalMinutes = '00:00:00';
				break;
			case '521629':
				$orderType = 'emailReport';
				$description = 'Email Report';
				$totalMinutes = '00:00:00';
				break;
			case '521626':
				$orderType = 'downloadChat';
				$description = 'Download Chat';
				$totalMinutes = '00:00:00';
				break;
			case '521625':
				$orderType = 'emailChat';
				$description = 'Email Chat';
				$totalMinutes = '00:00:00';
				break;
			default:
				$orderType = 'N/A';
				$description = 'N/A';
				$totalMinutes = '00:00:00';
				break;
		}

		$user = Auth::user();
		$pd = preg_replace('/\s+/', ' ',$payment_data['card_name']);

		$paymentYear = substr($payment_data['card_year'], -2);
		$paymentInfo = explode(' ', $pd);

		$pfname = isset($paymentInfo[0]) ? $paymentInfo[0] : '';
		$plname = isset($paymentInfo[1]) ? $paymentInfo[1] : '';

		$xml = '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  				<soap12:Body>
			    <ProcessOrder_ExistingAccount xmlns="http://www.livecosmos.com//">
			    <API_username>'.$this->API_username.'</API_username>
				<API_password>'.$this->API_password.'</API_password>
			      <MemberID>'.$user->member_id.'</MemberID>
			      <ATI_Order>
			        <ShippingInfo>
			          <FirstName>'.$data['first_name'].'</FirstName>
			          <LastName>'.$data['last_name'].'</LastName>
			          <Zip>'.trim($user->zip).'</Zip>
			          <Country>USA</Country>
			          <Email>'.$user->email.'</Email>
			        </ShippingInfo>
			        <BillingInfo>
			          <BillingAddress>
			            <FirstName>'.$pfname.'</FirstName>
			            <LastName>'.$plname.'</LastName>
			            <Zip>'.trim($payment_data['zip']).'</Zip>
			            <Country>USA</Country>
			            <Email>'.$user->email.'</Email>
			          </BillingAddress>
			          <CardNumber>'.trim($payment_data['card_number']).'</CardNumber>
			          <CVV>'.trim($payment_data['card_cvv']).'</CVV>
			          <ExpDate_MMYY>'.trim($payment_data['card_month'] . $paymentYear).'</ExpDate_MMYY>
			        </BillingInfo>
			       <CartItems>
			          <ATI_CartItem>
			            <ATI_Sku>'.$sku.'</ATI_Sku>
			            <qty>1</qty>
			          </ATI_CartItem>
			       </CartItems>
			      </ATI_Order>
			      <PreviewOnlyFlag>false</PreviewOnlyFlag>
			      <LeadID>0</LeadID>
			       <AID>'.$AID.'</AID>
					<SID>'.$SID.'</SID>
					<TID>'.$TID.'</TID>
			      <MemberIPAddress>'.$user->ip.'</MemberIPAddress>
			    </ProcessOrder_ExistingAccount>
			  </soap12:Body>
			  </soap12:Envelope>';


		//Log::debug($xml);

		$array = $this->parseXMLToJson($xml);

		if (isset($array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult'])) {
			if (isset($array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['Result']['ErrorMessage'])) {
				if (count($array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['Result']['ErrorMessage']) == 0) {
					return [
							'order_id' => $array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['OrderID'],
							'total' => $array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['Total'],
							'subtotal' => $array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['SubTotal'],
							'discount' => $array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['Discount'],
							'type'=>$orderType,
							'totalMinutes'=>$totalMinutes,
							'description' => $description,
					];
				} else {
					return ['error' => $array['ProcessOrder_ExistingAccountResponse']['ProcessOrder_ExistingAccountResult']['Result']['ErrorMessage']];
				}
			}
		}
	}

	// ProcessOrder_ExistingAccountExistingBillingInfo
	public function processOrderExistingAccountExistingBilling($data, $sku)
	{
		switch($sku){
			case '521622':
			case '521634':
				$orderType = 'minutes';
				$description = '5 Minute Package';
				$totalMinutes = '00:05:00';
				break;
			case '521623':
				$orderType = 'minutes';
				$description = '10 Minute Package';
				$totalMinutes = '00:10:00';
				break;
			case '521624':
				$orderType = 'minutes';
				$description = '15 Minute Package';
				$totalMinutes = '00:15:00';
				break;
			case '521632':
				$orderType = 'transit3';
				$description = 'Future Forecast Report';
				$totalMinutes = '00:00:00';
				break;
			case '521630':
				$orderType = 'natal';
				$description = 'Personal Map Report';
				$totalMinutes = '00:00:00';
				break;
			case '521631':
				$orderType = 'relationship';
				$description = 'Romantic Report';
				$totalMinutes = '00:00:00';
				break;
			default:
				$orderType = 'N/A';
				$description = 'N/A';
				$totalMinutes = '00:00:00';
				break;
		}
		$AID = $this->checkDomain();
		$TID = 1;
		$SID = '';

		if(Session::has('AID')){
			$AID = Session::get('AID');
		}
		if(Session::has('TID')){
			$TID = Session::get('TID');
		}
		if(Session::has('SID')){
			$SID = Session::get('SID');
		}


		$this->call('ProcessOrder_ExistingAccountExistingBillingInfo', [[
				'LeadID' => "0",
				'MemberID' => $data['member_id'],
				'API_username' => $this->API_username,
				'API_password' => $this->API_password,
				'ATI_Order' => [
						'ShippingInfo' => [
								'FirstName' => $data['first_name'],
								'LastName' => $data['last_name'],
								'Address1' => $data['address_1'],
								'City' => $data['city'],
								'Zip' => $data['zip'],
								'Country' => 'USA',
								'Phone' => $data['phone_number'],
								'Email' => $data['email'],
								'State' => $data['state']
						],
						'CartItems' => [
								'ATI_CartItem' => [
										'ATI_Sku' => $sku,
										'qty' => 1
								]
						],
				],
				'PreviewOnlyFlag' => false,
				'AID' => $AID,
				'TID' => $TID,
				'SID' => $SID,
		]]);

		$array = $this->parseXMLToJson();
		if (isset($array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult'])) {
			if (isset($array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['Result']['ErrorMessage'])) {
				if (count($array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['Result']['ErrorMessage']) == 0) {
					return [
							'order_id' => $array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['OrderID'],
							'total' => $array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['Total'],
							'subtotal' => $array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['SubTotal'],
							'discount' => $array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['Discount'],
							'type'=>$orderType,
							'totalMinutes'=>$totalMinutes,
							'description' => $description,
					];
				} else {
					return ['error' => $array['ProcessOrder_ExistingAccountExistingBillingInfoResponse']['ProcessOrder_ExistingAccountExistingBillingInfoResult']['Result']['ErrorMessage']];
				}
			}
		}
	}

}