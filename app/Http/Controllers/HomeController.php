<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\Base;
use App\Models\MonthlyExpensesSetting;
use App\Models\SalesPlan;
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
        // 売上計画の情報を取得
        $sales_plan = $HomeService->getSalesPlan(session('base_id'), $date->format('Ym'));
        // チャート表示に使用する条件をセッションに格納（チャート表示のAJAX通信で使用）
        $HomeService->inputSessionChartData($expenses, $result, $sales_plan);
        // 収支登録・修正情報に表示する情報を取得
        $balance_lists = $HomeService->getBalanceUpdateList();
        return view('home')->with([
            'bases' => $bases,
            'customer_results' => $result['customer_results'],
            'base_result' => $result['base_result'],
            'monthly_expenses' => $expenses['monthly_expenses'],
            'total_monthly_expenses_amount' => $expenses['total_monthly_expenses_amount'],
            'sales_plan' => $sales_plan,
            'balance_lists' => $balance_lists,
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
        // 売上計画の情報を取得
        $sales_plan = $HomeService->getSalesPlan(session('base_id'), $date->format('Ym'));
        // チャート表示に使用する条件をセッションに格納（チャート表示のAJAX通信で使用）
        $HomeService->inputSessionChartData($expenses, $result, $sales_plan);
        // 収支登録・修正情報に表示する情報を取得
        $balance_lists = $HomeService->getBalanceUpdateList();
        return view('home')->with([
            'bases' => $bases,
            'customer_results' => $result['customer_results'],
            'base_result' => $result['base_result'],
            'monthly_expenses' => $expenses['monthly_expenses'],
            'total_monthly_expenses_amount' => $expenses['total_monthly_expenses_amount'],
            'sales_plan' => $sales_plan,
            'balance_lists' => $balance_lists,
        ]);
    }

    public function balance_progress_get_ajax()
    {
        // 収支率（利益 / 月額経費）を算出(小数点2桁まで取得)
        $balance_progress_achieve = session('total_monthly_expenses_amount') == 0 ? 0 : round((session('total_profit') / session('total_monthly_expenses_amount'))*100, 2);
        // 達成率がマイナスだとチャートが正しく表示されないので、マイナスの場合は0にする、100を超えている場合は、超えてる数値に対応する差分を設定
        $balance_progress_achieve_chart = $balance_progress_achieve < 0 ? 0 : ($balance_progress_achieve < 100 ? $balance_progress_achieve : 100 - ($balance_progress_achieve - 100));
        // 未達成率を算出(達成率が100なら0、達成率がマイナスなら100、達成率が0～99.99なら100-達成率)
        $balance_progress_not_achieve_chart = $balance_progress_achieve >= 100 ? 0 : ($balance_progress_achieve < 0 ? 100 : 100 - $balance_progress_achieve);
        // 達成率が100を超えていた場合の数(達成率 - 100)
        $balance_progress_achieve_100_over = $balance_progress_achieve > 100 ? $balance_progress_achieve - 100 : 0;
        // 結果を返す
        return response()->json([
            'balance_progress_achieve' => $balance_progress_achieve,
            'balance_progress_achieve_chart' => $balance_progress_achieve_chart,
            'balance_progress_not_achieve_chart' => $balance_progress_not_achieve_chart,
            'balance_progress_achieve_100_over' => $balance_progress_achieve_100_over,
        ]);
    }

    public function sales_plan_progress_get_ajax()
    {
        // 達成率（売上実績 / 売上計画）を算出(小数点2桁まで取得)
        $sales_plan_progress_achieve = session('sales_plan_amount') == 0 ? 0 : round((session('total_sales') / session('sales_plan_amount'))*100, 2);
        // 達成率がマイナスだとチャートが正しく表示されないので、マイナスの場合は0にする、100を超えている場合は、超えてる数値に対応する差分を設定
        $sales_plan_progress_achieve_chart = $sales_plan_progress_achieve < 0 ? 0 : ($sales_plan_progress_achieve < 100 ? $sales_plan_progress_achieve : 100 - ($sales_plan_progress_achieve - 100));
        // 未達成率を算出(達成率が100なら0、達成率がマイナスなら100、達成率が0～99.99なら100-達成率)
        $sales_plan_progress_not_achieve_chart = $sales_plan_progress_achieve >= 100 ? 0 : ($sales_plan_progress_achieve < 0 ? 100 : 100 - $sales_plan_progress_achieve);
        // 達成率が100を超えていた場合の数(達成率 - 100)
        $sales_plan_progress_achieve_100_over = $sales_plan_progress_achieve > 100 ? $sales_plan_progress_achieve - 100 : 0;
        // 結果を返す
        return response()->json([
            'sales_plan_progress_achieve' => $sales_plan_progress_achieve,
            'sales_plan_progress_achieve_chart' => $sales_plan_progress_achieve_chart,
            'sales_plan_progress_not_achieve_chart' => $sales_plan_progress_not_achieve_chart,
            'sales_plan_progress_achieve_100_over' => $sales_plan_progress_achieve_100_over,
        ]);
    }
}
