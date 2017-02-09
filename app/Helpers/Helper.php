<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use GuzzleHttp;
use Auth;
use App\Models\Report;
use GuzzleHttp\Psr7;
use App\Models\OtherUser;
use App\User;

class Helper
{
	public static function shout(string $string)
	{
		return strtoupper($string);
	}

	public static function getMonthNumber($month)
	{
		$date = $month . ' 25 2010';
		return date('m', strtotime($date));
	}

	public static function getReport($type, $other_user_id = null, $user_id = null){
		$user = Auth::user();
		if ($type !== 'relationship' && $other_user_id !== null) {
			$user = OtherUser::find($other_user_id);
			$birth = explode('/', $user->birth_month);
			$day = $birth[0];
			$month = $birth[1];
			$year = $birth[2];
			$birth_hour = $user->birth_time_hour;
			$birth_minute = $user->birth_time_minute;
		} else {
			if($user_id != null){
				$user=User::find($user_id);
			}
			$day = $user->birth_day;
			$month = $user->monthNumber();
			$year = $user->birth_year;
			$btime = explode(':', $user->birth_time);
			if (count($btime) > 1) {
				if (isset($btime[0])) {
					$birth_hour = $btime[0];
					if (strlen($birth_hour) == 1) {
						$birth_hour = '0' . $btime[0];
					}
				} else {
					$birth_hour = '00';
				}
				if (isset($btime[1])) {
					$birth_minute = $btime[1];
				} else {
					$birth_minute = '00';
				}
			} else {
				$birth_hour = '00';
				$birth_minute = '00';
			}
		}

		$client = new GuzzleHttp\Client();
		//  k=***&id=456&type=transit3&name=John&nick=Joe&city=Washington&state=NY&country=USA&day=10&month=04&year=1990&hour=09&minute=20
		$query = [
				'k' => '673265',
				'id' => $user->id,
				'type' => $type,
				'name' => $user->first_name. ' '. $user->last_name,
				'nick' => $user->name,
				'city' => $user->city,
				'state' => urlencode($user->state),
				'country' => 'USA',
				'day' => $day,
				'month' => $month,
				'year' => $year,
				'hour' => $birth_hour,
				'minute' => $birth_minute
		];

		if($type === 'transit3'){
			$query = array_merge($query,[
				'c_city'=>$user->city,
				'c_state'=>urlencode($user->state),
				'c_country' => 'USA',
			]);
		}

		if($type === 'relationship' && $other_user_id){
			$other_user = OtherUser::find($other_user_id);
			$birth = explode('/',$other_user->birth_month);
			$query = array_merge($query,[
					'name2'=>$other_user->first_name.' '.$other_user->last_name,
					'state2'=>urlencode($other_user->state),
					'city2'=>urlencode($other_user->city),
					'day2'=>$birth[0],
					'month2'=>$birth[1],
					'year2'=>$birth[2],
					'country2' => 'USA',
					'hour2'=>$other_user->birth_time_hour,
					'minute2'=>$other_user->birth_time_minute,

					'c_city'=>$user->c_city?:$user->city,
					'c_state'=>$user->c_state?:urlencode($user->state),
					'c_country' => 'USA',
			]);
		}

		try {
			$res = $client->get('http://www.astrobuilder.net:8010/livecosmos/show.php', [
					'query' => $query
			]);
		} catch (GuzzleHttp\Exception\RequestException $e) {
			if ($e->hasResponse()) {
				return  $e->getResponse()->getBody()->getContents();
			}
			return  Psr7\str($e->getRequest());
		}

		$report2 = str_replace(['Interpretation text by Henry Seltzer<br>',
				'Copyright 1999 - 2014 AstroGraph Software, Inc.<br>',
				'Powered by: AstroGraph Software<br>',
				'<h4>About the Author</h4>',
				'<p>Henry Seltzer is a consulting astrologer with over 20 years experience. A well-known speaker and writer, he holds degrees from MIT, NYU and the University of California, San Diego, and created the popular TimePassages software in 1995. His approach to astrology is based on personal transformation, an optimistic assessment that more than anything, people want to understand the fundamental meaning of their lives and grow as individuals. Henry currently maintains an active astrological counseling practice in Santa Cruz, CA; to learn more about his work, visit www.astrograph.com.</p><br>'
		], '', utf8_decode($res->getBody()));


		$report = new Report();
		$report->user_id = $user->id;
		$report->type = $type;
		$report->status = 'New';
		$report->paid = '1';
		$report->text = $report2;

		if(!$report->save()){
			return false;
		}

		return $report;
	}

	public static function getSigns()
	{
		return [
			'Aries' => 'Aries',
			'Taurus' => 'Taurus',
			'Gemini' => 'Gemini',
			'Cancer' => 'Cancer',
			'Leo' => 'Leo',
			'Virgo' => 'Virgo',
			'Libra' => 'Libra',
			'Scorpio' => 'Scorpio',
			'Sagittarius' => 'Sagittarius',
			'Capricorn' => 'Capricorn',
			'Aquarius' => 'Aquarius',
			'Pisces' => 'Pisces'
		];
	}

	public static function signDatesIsInvalid($request, $user = null)
	{
		$bmonth = $request->get('birth_month');
		$bday = (int)$request->get('birth_day');
		if (!$request->has('sign') && $user) {
			$sign = $user->sign;
		} else {
			$sign = $request->get('sign');
		}
		switch ($sign) {
			case 'Aries':
				if ($bmonth == 'March' || $bmonth == 'April') {
					if (($bday >= 21 && $bmonth == 'March') || ($bday <= 19 && $bmonth == 'April')) {
						return true;
					}
				}

				break;
			case 'Taurus':
				if ($bmonth == 'May' || $bmonth == 'April') {
					if (($bday >= 20 && $bmonth == 'April') || ($bday <= 20 && $bmonth == 'May')) {
						return true;
					}
				}

				break;
			case 'Gemini':
				if ($bmonth == 'May' || $bmonth == 'June') {
					if (($bday >= 21 && $bmonth == 'May') || ($bday <= 20 && $bmonth == 'June')) {
						return true;
					}
				}

				break;
			case 'Cancer':
				if ($bmonth == 'June' || $bmonth == 'July') {
					if (($bday >= 21 && $bmonth == 'June') || ($bday <= 22 && $bmonth == 'July')) {
						return true;
					}
				}

				break;
			case 'Leo':
				if ($bmonth == 'July' || $bmonth == 'August') {
					if (($bday >= 23 && $bmonth == 'July') || ($bday <= 22 && $bmonth == 'August')) {
						return true;
					}
				}

				break;
			case 'Virgo':
				if ($bmonth == 'August' || $bmonth == 'September') {
					if (($bday >= 23 && $bmonth == 'August') || ($bday <= 22 && $bmonth == 'September')) {
						return true;
					}
				}

				break;
			case 'Libra':
				if ($bmonth == 'September' || $bmonth == 'October') {
					if (($bday >= 23 && $bmonth == 'September') || ($bday <= 22 && $bmonth == 'October')) {
						return true;
					}
				}

				break;
			case 'Scorpio':
				if ($bmonth == 'October' || $bmonth == 'November') {
					if (($bday >= 23 && $bmonth == 'October') || ($bday <= 21 && $bmonth == 'November')) {
						return true;
					}
				}

				break;
			case 'Sagittarius':
				if ($bmonth == 'November' || $bmonth == 'December') {
					if (($bday >= 22 && $bmonth == 'November') || ($bday <= 21 && $bmonth == 'December')) {
						return true;
					}
				}

				break;
			case 'Capricorn':
				if ($bmonth == 'January' || $bmonth == 'December') {
					if (($bday >= 22 && $bmonth == 'December') || ($bday <= 19 && $bmonth == 'January')) {
						return true;
					}
				}

				break;
			case 'Aquarius':
				if ($bmonth == 'January' || $bmonth == 'February') {
					if (($bday >= 20 && $bmonth == 'January') || ($bday <= 18 && $bmonth == 'February')) {
						return true;
					}
				}

				break;
			case 'Pisces':
				if ($bmonth == 'February' || $bmonth == 'March') {
					if (($bday >= 19 && $bmonth == 'February') || ($bday <= 20 && $bmonth == 'March')) {
						return true;
					}
				}

				break;
		}
	}

}