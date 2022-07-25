/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/balance_modify.js ***!
  \****************************************/
window.onload = function () {
  total_fare_sales_update();
  total_fare_expenses_update();
  total_cargo_handling_update();
  total_labor_costs_update();
  total_other_sales_update();
  total_other_expenses_update();
}; // 運賃関連の合計を更新


function total_fare_sales_update() {
  // 個口合計を更新
  var box_quantity_sum = 0;
  var box_quantity_element = document.getElementsByClassName('box_quantity_sales');

  for (var i = 0; i < box_quantity_element.length; i++) {
    box_quantity_sum += isNaN(box_quantity_element[i].value) ? 0 : Number(box_quantity_element[i].value);
  }

  total_box_quantity_sales.innerHTML = box_quantity_sum.toLocaleString(); // 運賃金額合計を更新

  var fare_amount_sum = 0;
  var fare_amount_element = document.getElementsByClassName('fare_amount_sales');

  for (var _i = 0; _i < fare_amount_element.length; _i++) {
    fare_amount_sum += isNaN(fare_amount_element[_i].value) ? 0 : Number(fare_amount_element[_i].value);
  }

  total_fare_sales.innerHTML = fare_amount_sum.toLocaleString();
} // 荷役関連の合計を更新


function total_cargo_handling_update() {
  // 作業合計を更新
  var operation_quantity_sum = 0;
  var operation_quantity_element = document.getElementsByClassName('operation_quantity');

  for (var i = 0; i < operation_quantity_element.length; i++) {
    operation_quantity_sum += isNaN(operation_quantity_element[i].value) ? 0 : Number(operation_quantity_element[i].value);
  }

  total_operation_quantity.innerHTML = operation_quantity_sum.toLocaleString(); // 荷役金額合計を更新

  var cargo_handling_amount_sum = 0;
  var cargo_handling_amount_element = document.getElementsByClassName('cargo_handling_amount');

  for (var _i2 = 0; _i2 < cargo_handling_amount_element.length; _i2++) {
    cargo_handling_amount_sum += isNaN(cargo_handling_amount_element[_i2].value) ? 0 : Number(cargo_handling_amount_element[_i2].value);
  }

  total_cargo_handling.innerHTML = cargo_handling_amount_sum.toLocaleString();
} // 運賃関連の合計を更新


function total_fare_expenses_update() {
  // 個口合計を更新
  var box_quantity_sum = 0;
  var box_quantity_element = document.getElementsByClassName('box_quantity_expenses');

  for (var i = 0; i < box_quantity_element.length; i++) {
    box_quantity_sum += isNaN(box_quantity_element[i].value) ? 0 : Number(box_quantity_element[i].value);
  }

  total_box_quantity_expenses.innerHTML = box_quantity_sum.toLocaleString(); // 運賃金額合計を更新

  var fare_amount_sum = 0;
  var fare_amount_element = document.getElementsByClassName('fare_amount_expenses');

  for (var _i3 = 0; _i3 < fare_amount_element.length; _i3++) {
    fare_amount_sum += isNaN(fare_amount_element[_i3].value) ? 0 : Number(fare_amount_element[_i3].value);
  }

  total_fare_expenses.innerHTML = fare_amount_sum.toLocaleString();
} // 人件費関連の合計を更新


function total_labor_costs_update() {
  // 時間合計を更新
  var working_time_sum = 0;
  var working_time_element = document.getElementsByClassName('working_time');

  for (var i = 0; i < working_time_element.length; i++) {
    working_time_sum += isNaN(working_time_element[i].value) ? 0 : Number(working_time_element[i].value);
  }

  total_working_time.innerHTML = working_time_sum.toLocaleString(); // 金額合計を更新

  var labor_costs_sum = 0;
  var labor_costs_element = document.getElementsByClassName('labor_costs');

  for (var _i4 = 0; _i4 < labor_costs_element.length; _i4++) {
    labor_costs_sum += isNaN(labor_costs_element[_i4].value) ? 0 : Number(labor_costs_element[_i4].value);
  }

  total_labor_costs.innerHTML = labor_costs_sum.toLocaleString();
} // その他売上の合計金額更新処理


function total_other_sales_update() {
  // 金額合計を更新
  var other_sales_amount_sum = 0;
  var other_sales_amount_element = document.getElementsByClassName('other_sales_amount');

  for (var i = 0; i < other_sales_amount_element.length; i++) {
    other_sales_amount_sum += isNaN(other_sales_amount_element[i].value) ? 0 : Number(other_sales_amount_element[i].value);
  }

  total_other_sales_amount.innerHTML = other_sales_amount_sum.toLocaleString();
} // その他経費の合計金額更新処理


function total_other_expenses_update() {
  // 金額合計を更新
  var other_expenses_amount_sum = 0;
  var other_expenses_amount_element = document.getElementsByClassName('other_expenses_amount');

  for (var i = 0; i < other_expenses_amount_element.length; i++) {
    other_expenses_amount_sum += isNaN(other_expenses_amount_element[i].value) ? 0 : Number(other_expenses_amount_element[i].value);
  }

  total_other_expenses_amount.innerHTML = other_expenses_amount_sum.toLocaleString();
}
/******/ })()
;