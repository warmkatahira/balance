const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/navigation.js', 'public/js')
    .js('resources/js/balance_register.js', 'public/js')
    .js('resources/js/balance_modify.js', 'public/js')
    .js('resources/js/balance_detail_chart.js', 'public/js')
    .js('resources/js/customer.js', 'public/js')
    .js('resources/js/cargo_handling.js', 'public/js')
    .js('resources/js/expenses_item.js', 'public/js')
    .js('resources/js/monthly_expenses_setting.js', 'public/js')
    .js('resources/js/labor_cost_setting.js', 'public/js')
    .js('resources/js/balance_list.js', 'public/js')
    .js('resources/js/sales_item.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .autoload({
        jquery: ['$', 'window.jQuery']
    })
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ]
);
