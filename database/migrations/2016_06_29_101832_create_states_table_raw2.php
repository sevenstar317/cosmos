<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTableRaw2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Alaska\', \'AK\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Alabama\', \'AL\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Arkansas\', \'AR\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Arizona\', \'AZ\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'California\', \'CA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Colorado\', \'CO\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Connecticut\', \'CT\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'District of Columbia\', \'DC\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Delaware\', \'DE\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Florida\', \'FL\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Georgia\', \'GA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Hawaii\', \'HI\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Iowa\', \'IA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Idaho\', \'ID\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Illinois\', \'IL\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Indiana\', \'IN\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Kansas\', \'KS\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Kentucky\', \'KY\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Louisiana\', \'LA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Massachusetts\', \'MA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Maryland\', \'MD\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Maine\', \'ME\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Michigan\', \'MI\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Minnesota\', \'MN\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Missouri\', \'MO\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Mississippi\', \'MS\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Montana\', \'MT\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'North Carolina\', \'NC\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'North Dakota\', \'ND\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Nebraska\', \'NE\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'New Hampshire\', \'NH\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'New Jersey\', \'NJ\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'New Mexico\', \'NM\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Nevada\', \'NV\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'New York\', \'NY\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Ohio\', \'OH\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Oklahoma\', \'OK\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Oregon\', \'OR\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Pennsylvania\', \'PA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Rhode Island\', \'RI\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'South Carolina\', \'SC\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'South Dakota\', \'SD\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Tennessee\', \'TN\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Texas\', \'TX\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Utah\', \'UT\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Virginia\', \'VA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Vermont\', \'VT\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Washington\', \'WA\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Wisconsin\', \'WI\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'West Virginia\', \'WV\');
INSERT INTO `states` (`state`,`state_code`) VALUES (\'Wyoming\', \'WY\');
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
