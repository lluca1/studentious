<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Collection;

class CalendarService
{
    /**
     * Generate ICS content for a single event.
     *
     * @param Event $event
     * @return string
     */
    public function generateEventIcs(Event $event): string
    {
        $icsContent = "BEGIN:VCALENDAR\r\n";
        $icsContent .= "VERSION:2.0\r\n";
        $icsContent .= "PRODID:-//Studentious//NONSGML Event Calendar//EN\r\n";
        $icsContent .= "CALSCALE:GREGORIAN\r\n";
        $icsContent .= $this->formatEventForIcs($event);
        $icsContent .= "END:VCALENDAR";

        return $icsContent;
    }

    /**
     * Generate ICS content for multiple events.
     *
     * @param Collection $events
     * @return string
     */
    public function generateEventsIcs(Collection $events): string
    {
        $icsContent = "BEGIN:VCALENDAR\r\n";
        $icsContent .= "VERSION:2.0\r\n";
        $icsContent .= "PRODID:-//Studentious//NONSGML Event Calendar//EN\r\n";
        $icsContent .= "CALSCALE:GREGORIAN\r\n";
        
        foreach ($events as $event) {
            $icsContent .= $this->formatEventForIcs($event);
        }
        
        $icsContent .= "END:VCALENDAR";

        return $icsContent;
    }

    /**
     * Format a single event for inclusion in an ICS file.
     *
     * @param Event $event
     * @return string
     */
    protected function formatEventForIcs(Event $event): string
    {
        $icsEvent = "BEGIN:VEVENT\r\n";
        $icsEvent .= "UID:" . $event->id . "@studentious.app\r\n";
        $icsEvent .= "SUMMARY:" . $this->escapeString($event->title) . "\r\n";
        $icsEvent .= "DESCRIPTION:" . $this->escapeString($event->description) . "\r\n";
        $icsEvent .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
        $icsEvent .= "DTSTART:" . $event->start_time->format('Ymd\THis\Z') . "\r\n";
        $icsEvent .= "DTEND:" . $event->end_time->format('Ymd\THis\Z') . "\r\n";
        $icsEvent .= "END:VEVENT\r\n";
        
        return $icsEvent;
    }

    /**
     * Escape string for ICS format.
     *
     * @param string|null $string
     * @return string
     */
    protected function escapeString(?string $string): string
    {
        if (!$string) {
            return '';
        }
        
        $string = str_replace(["\r\n", "\n", "\r"], "\\n", $string);
        
        $string = str_replace([",", ";", "\\"], ["\\,", "\\;", "\\\\"], $string);
        
        return $string;
    }
}