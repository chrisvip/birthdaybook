<?php

namespace Tests\Unit;

use DateTime;
use DateTimeZone;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Utils\TimeTillAnniversary;


class TimeTillAnniversaryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_today_anniversary()
    {
        $now = new DateTime('1/1/2020', new DateTimeZone('America/Los_Angeles'));
        $tta = new TimeTillAnniversary('1/1/2000', 'America/Los_Angeles', $asOf=$now);

        $this->assertTrue($tta->isToday());
        $this->assertEquals($tta->ageAtAnniversary(), 20);
        $this->assertEquals(str($tta), 'today (23 hours remaining in America/Los_Angeles)');
    }

    public function test_today_anniversary_different_tz()
    {
        $now = new DateTime('1/1/2020', new DateTimeZone('America/Los_Angeles'));
        $tta = new TimeTillAnniversary('1/1/2000', 'America/New_York', $asOf=$now);

        $this->assertTrue($tta->isToday());
        $this->assertEquals($tta->ageAtAnniversary(), 20);
        $this->assertEquals(str($tta), 'today (20 hours remaining in America/New_York)');
    }

    public function test_already_past_anniversary()
    {
        $now = new DateTime('6/1/2020', new DateTimeZone('America/Los_Angeles'));
        $tta = new TimeTillAnniversary('5/31/2000', 'America/New_York', $asOf=$now);

        $this->assertFalse($tta->isToday());
        $this->assertEquals($tta->ageAtAnniversary(), 21);
        $this->assertEquals(str($tta), 'in 11 month(s), 30 day(s) in America/New_York');
    }

    public function test_upcoming_anniversary()
    {
        $now = new DateTime('6/1/2020', new DateTimeZone('America/Los_Angeles'));
        $tta = new TimeTillAnniversary('6/2/2000', 'America/New_York', $asOf=$now);

        $this->assertFalse($tta->isToday());
        $this->assertEquals($tta->ageAtAnniversary(), 20);
        $this->assertEquals(str($tta), 'in 1 day(s) in America/New_York');
    }

    public function test_future_birth()
    {
        $now = new DateTime('6/1/2020', new DateTimeZone('America/Los_Angeles'));
        $tta = new TimeTillAnniversary('1/15/2025', 'America/New_York', $asOf=$now);

        $this->assertFalse($tta->isToday());
        $this->assertEquals($tta->ageAtAnniversary(), 0);
        $this->assertEquals(str($tta), 'in 4 year(s), 7 month(s), 14 day(s) in America/New_York');
    }

}
