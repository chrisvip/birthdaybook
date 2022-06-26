<?php

namespace App\Utils;

use DateTime;
use DateTimeZone;
use DateInterval;

class TimeTillAnniversary {
    private $asOf;
    private $birthDate;
    private $anniversaryDate;
    private $timeLeft;

    public function __construct(string $birthDateStr, string $tzStr, DateTime $asOf=null) {
        $this->asOf = $asOf ?? new DateTime();

        $tz = new DateTimeZone($tzStr);

        $this->birthDate = new DateTime($birthDateStr, $tz);
        $this->birthDate->setTime(23, 59, 59);
        
        $this->anniversaryDate = new DateTime();
        $this->anniversaryDate->setTimeZone($tz);
        $this->anniversaryDate->setTime(23, 59, 59);
        $this->anniversaryDate->setDate(
            $this->birthDate <= $this->asOf? $this->asOf->format('Y') : $this->birthDate->format('Y'), 
            $this->birthDate->format('m'), 
            $this->birthDate->format('d')
        );
        if ($this->anniversaryDate <= $this->asOf) {
            $this->anniversaryDate->modify('+1 year');
        }
        $this->timeLeft = $this->asOf->diff($this->anniversaryDate);
    }
    
    public function raw(): DateInterval {
        return $this->timeLeft;
    }

    public function isToday() {
        return $this->timeLeft->days == 0;
    }

    public function ageAtAnniversary() {
        $diff = $this->birthDate->diff($this->asOf);
        return $diff->invert ? 0 : $diff->y+1;
    }

    public function __toString() {
        if ($this->isToday()) {
            return 'today (' . $this->timeLeft->h . ' hours remaining in ' 
                . $this->anniversaryDate->format('e') . ')';
        } else {
            $parts = [];
            if ($this->timeLeft->y > 0) $parts[] = $this->timeLeft->y . ' year(s)';
            if ($this->timeLeft->m > 0) $parts[] = $this->timeLeft->m . ' month(s)';
            if ($this->timeLeft->d > 0) $parts[] = $this->timeLeft->d . ' day(s)';
            return 'in ' . join(', ', $parts) . ' in ' . $this->anniversaryDate->format('e');
        }
    }
}
