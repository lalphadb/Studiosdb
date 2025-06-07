<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatsDates
{
    /**
     * Format date en français canadien (JJ/MM/AAAA)
     */
    public function formatDate($date)
    {
        if (! $date) {
            return '';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->format('d/m/Y');
    }

    /**
     * Format date et heure en français canadien
     */
    public function formatDateTime($datetime)
    {
        if (! $datetime) {
            return '';
        }

        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime);
        }

        return $datetime->format('d/m/Y H:i');
    }

    /**
     * Format heure en 24h
     */
    public function formatTime($time)
    {
        if (! $time) {
            return '';
        }

        if (is_string($time)) {
            $time = Carbon::parse($time);
        }

        return $time->format('H:i');
    }
}
