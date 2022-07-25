<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommonService
{
    public function getMonthStartEndDate($date)
    {
        // 今月の月初の日付を取得
        $date_start_of_month = new Carbon($date);
        $date_start_of_month = $date_start_of_month->startOfMonth()->format('Y-m-d');
        // 今月の月末の日付を取得
        $date_end_of_month = new Carbon($date);
        $date_end_of_month = $date_end_of_month->endOfMonth()->format('Y-m-d');
        return with([
            'date_start_of_month' => $date_start_of_month,
            'date_end_of_month' => $date_end_of_month,
        ]);
    }
}