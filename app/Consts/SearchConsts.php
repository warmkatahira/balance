<?php

namespace App\Consts;

class SearchConsts
{
    // 検索条件の「検索区分」のプルダウン
    public const SEARCH_CATEGORY_ZENSHA = '全社';
    public const SEARCH_CATEGORY_BASE = '拠点';
    public const SEARCH_CATEGORY_CUSTOMER = '荷主';
    public const SEARCH_CATEGORY_LIST = [
        self::SEARCH_CATEGORY_ZENSHA => self::SEARCH_CATEGORY_ZENSHA,
        self::SEARCH_CATEGORY_BASE => self::SEARCH_CATEGORY_BASE,
        self::SEARCH_CATEGORY_CUSTOMER => self::SEARCH_CATEGORY_CUSTOMER,
    ];

    // 検索条件の「日付区分」のプルダウン
    public const DATE_CATEGORY_DAY = '日別';
    public const DATE_CATEGORY_MONTH = '月別';
    public const DATE_CATEGORY_LIST = [
        self::DATE_CATEGORY_DAY => self::DATE_CATEGORY_DAY,
        self::DATE_CATEGORY_MONTH => self::DATE_CATEGORY_MONTH,
    ];
}