/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/chart.js ***!
  \*******************************/
window.onload = function () {
  var context = document.querySelector("#japanese_people_chart").getContext('2d');
  new Chart(context, {
    type: 'doughnut',
    data: {
      labels: ['本社', '第1', '第2', '第3', '第4', 'ロジS'],
      datasets: [{
        label: "日本の人口推移",
        data: [0, 10, 5, 8, 12, 19],
        backgroundColor: ["rgba(219,39,91,0.5)", "rgba(219,39,91,0.5)", "rgba(130,249,255,1)", "gray", "red", "gray"]
      }]
    },
    options: {
      responsive: false
    }
  });
};
/******/ })()
;