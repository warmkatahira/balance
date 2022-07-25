<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\Base;
use App\Models\MonthlyExpensesSetting;
use Carbon\Carbon;

use App\Services\CommonService;
use App\Services\HomeService;

class HomeController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        $HomeService = new HomeService;
        // 対象の拠点IDをセッションに格納
        session(['base_id' => Auth::user()->base_id]);
        // 拠点の情報を取得
        $bases = $HomeService->getBase();
        // 現在の日時を取得
        $date = new Carbon('now');
        // 対象の日を年月にフォーマット
        $HomeService->formatTargetDate($date);
        // 月初と月末の日付を取得
        $MonthStartEndDate = $CommonService->getMonthStartEndDate($date);
        // 対象拠点の成績を取得
        $result = $HomeService->getResult(session('base_id'), $MonthStartEndDate);
        // 月額経費の情報を取得
        $expenses = $HomeService->getMonthlyExpenses(session('base_id'), $date->format('Ym'));
        // チャート表示に使用する条件をセッションに格納（チャート表示のAJAX通信で使用）
        $HomeService->inputSessionChartData($expenses, $result);
        return view('home')->with([
            'bases' => $bases,
            'customer_results' => $result['customer_results'],
            'base_result' => $result['base_result'],
            'monthly_expenses' => $expenses['monthly_expenses'],
            'total_monthly_expenses_amount' => $expenses['total_monthly_expenses_amount'],
        ]);
    }

    public function month_result_disp(Request $request)
    {
        // サービスクラスを定義
        $CommonService = new CommonService;
        $HomeService = new HomeService;
        // 対象の拠点IDをセッションに格納
        session(['base_id' => $request->base_select]);
        // 拠点の情報を取得
        $bases = $HomeService->getBase();
        // 対象の年月を取得
        $date = new Carbon($request->month_select);
        // 対象の日を年月にフォーマット
        $HomeService->formatTargetDate($date);
        // 月初と月末の日付を取得
        $MonthStartEndDate = $CommonService->getMonthStartEndDate($date);
        // 対象拠点の成績を取得
        $result = $HomeService->getResult(session('base_id'), $MonthStartEndDate);
        // 月額経費の情報を取得
        $expenses = $HomeService->getMonthlyExpenses(session('base_id'), $date->format('Ym'));
        // チャート表示に使用する条件をセッションに格納（チャート表示のAJAX通信で使用）
        $HomeService->inputSessionChartData($expenses, $result);
        return view('home')->with([
            'bases' => $bases,
            'customer_results' => $result['customer_results'],
            'base_result' => $result['base_result'],
            'monthly_expenses' => $expenses['monthly_expenses'],
            'total_monthly_expenses_amount' => $expenses['total_monthly_expenses_amount'],
        ]);
    }

    public function balance_progress_get_ajax()
    {
        // 達成率（利益 / 月額経費）を算出(小数点2桁まで取得)
        $balance_progress_achieve = session('total_monthly_expenses_amount') == 0 ? 0 : round((session('total_profit') / session('total_monthly_expenses_amount'))*100, 2);
        // 達成率がマイナスだとチャートが正しく表示されないので、マイナスの場合は0にする
        $balance_progress_achieve_chart = $balance_progress_achieve < 0 ? 0 : $balance_progress_achieve;
        // 未達成率を算出(達成率が100なら0、達成率がマイナスなら100、達成率が0～99.99なら100-達成率)
        $balance_progress_not_achieve_chart = $balance_progress_achieve >= 100 ? 0 : ($balance_progress_achieve < 0 ? 100 : 100 - $balance_progress_achieve);
        // 結果を返す
        return response()->json([
            'balance_progress_achieve' => $balance_progress_achieve,
            'balance_progress_achieve_chart' => $balance_progress_achieve_chart,
            'balance_progress_not_achieve_chart' => $balance_progress_not_achieve_chart,
        ]);
    }
}
