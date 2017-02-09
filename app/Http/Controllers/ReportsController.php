<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\AgentUser;
use App\Models\ChatMessage;
use App\Models\Report;
use App\Models\Soap;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;
use PDF;

class ReportsController extends Controller
{
	function getReport()
	{
		$type = 'natal';
		Helper::getReport($type);
	}

	public function viewReport($id){
		$user = Auth::user();

		$report = Report::find($id);

		return view('dashboard.view_report', ['user' => $user, 'report' => $report]);
	}


	/**
	 * @param $id
	 * @return mixed
	 */
	function downloadPdfReport($id)
	{
		$report = Report::where('id', $id)->first();
		$pdf = PDF::loadHtml($report->text);
		return $pdf->download('report_' . $report->type . '.pdf');
	}


	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	function emailReport($id)
	{
		$user = Auth::user();
		$report = Report::where('id', $id)->first();
		if ($report->paid_for_email == '1') {
			Mail::send(array(), array(), function ($message) use ($report, $user) {
				$message->to($user->email)
					->subject('Livecosmos Report')
					->setBody($report->text, 'text/html');
			});

			if (count(Mail::failures()) > 0) {

				return response()
					->json(['error' => 'There was one or more failures.'], 400);

			} else {
				return response()
					->json(['success' => 'success']);
			}
		} else {
			return response()
				->json(['error' => 'Please pay'], 400);
		}
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	function emailChat($id)
	{
		$chat = AgentUser::find($id);
		if ($chat->paid_for_email == '1') {
			$messages = ChatMessage::where('chat_id', $id)->get();
			$user = Auth::user();
			Mail::send('emails.chat-messages', ['messages' => $messages], function ($m) use ($user) {
				$m->to($user->email)->subject('Livecosmos chat messages');
			});

			if (count(Mail::failures()) > 0) {

				return response()
					->json(['error' => 'There was one or more failures.'], 400);

			} else {
				return response()
					->json(['success' => 'success']);
			}
		} else {
			return response()
				->json(['error' => 'Please pay'], 400);
		}
	}


	function apiTest()
	{
		/*
		 * https://secure.livecosmos.com/secure/admin
lcadmin
Live48CT35@


 https://secure.livecosmos.com/webservices/api.asmx
lcapiuser
Tdn7kYr39D
		 */

		$soap = new Soap();
		//	print_r($soap->functions());
		//	$client = $soap->createClient();
		$soap->call('CreateLead', [[
			'API_username' => 'lcadmin',
			'API_password' => 'Live48CT35@',
			'MemberFirstName' => 'John',
			'MemberLastName' => 'Doe',
			'MemberEmail' => 'abra@ttt.com',
			'MemberPassword' => 'password',
			'AID' => '1',
			'TID' => '1',
			'PhoneNumber' => '4354']]);

		//	print_r($soap->getLastResponse());
		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soap->getLastResponse());
		$xml = new SimpleXMLElement($response);
		$body = $xml->xpath('//soapBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE);
		print_r($array['CreateLeadResponse']['CreateLeadResult']['LeadID']);
		print_r($array['CreateLeadResponse']['CreateLeadResult']['Result']['ErrorMessage']);
		print_r($array['CreateLeadResponse']['CreateLeadResult']['MemberID']);


	}
}
