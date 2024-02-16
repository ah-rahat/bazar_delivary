<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|php artisan make:model Todo -mcr
*/

Auth::routes();

 

Route::get('/stripe', 'StripePaymentController@stripe')->name('stripe');
Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/token-auth', 'UserController@notify_token_send')->name('notify_token_send');
Route::post('/login-admin', 'Auth\LoginController@authenticate')->name('authenticate');
Route::get('/adminlogin', 'Auth\LoginController@oldlogin')->name('adminlogin');



Route::get('/order-activity', 'OrderController@order_activity')->name('order_activity');
Route::get('/shop-order-activity', 'ShopController@shop_order_activity')->name('shop_order_activity');
Route::get('/low-stock', 'OrderController@low_stock')->name('low_stock');


Route::get('register', function () {
//    // Only authenticated users may enter...
})->middleware('admin');


Route::get('/change-password', 'HomeController@change_password')->name('change_password');
Route::post('/update_password', 'HomeController@update_password')->name('update_password');


Route::group(['prefix' => 'shop', 'middleware' => ['shop']], function () {
    Route::get('/shop/shop-expense', 'ShopController@shop_expense')->name('shop_expense');
    Route::post('shop/save-shop-expense', 'ShopController@save_shop_expense');
    Route::get('/shop/extra-money', 'ShopController@extra_money')->name('extra_money');
    Route::post('shop/save-extra-money', 'ShopController@save_extra_money');

    //shop order

    Route::get('/shop/today-orders', 'ShopController@today_orders')->name('today_orders');
    Route::get('/shop/order/{id}', 'ShopController@single_order')->name('single_order');
    Route::get('/shop/today-orders/delivered/{date}', 'ShopController@today_delivered_orders')->name('today_delivered_orders');
    Route::get('/shop/dayend-sold-products/{date}', 'ShopController@shop_dayend_sold_products')->name('shop_dayend_sold_products');


    Route::get('/shop-investment', 'ShopController@investment')->name('Shop investment');
    Route::post('/save-shop-money', 'ShopController@save_shop_stock_money');

    Route::get('/sales-calculation/{start_date}/{end_date}', 'ShopController@sales_calculation')->name('sales_calculation');

    Route::get('/', 'ShopController@index')->name('Shop Home');
    Route::get('/products', 'ShopController@product_lists')->name('product_lists');
    Route::get('/products/{id}', 'ShopController@edit_product')->name('edit_product');
    Route::get('/add-product', 'ShopController@add_product')->name('add_product');
    Route::post('/create_product', 'ShopController@create_product')->name('create_product');
    Route::post('/update_product', 'ShopController@update_product')->name('update_product');

    Route::get('/product/stock', 'ShopController@stock')->name('stock');
    Route::get('/inactive-products', 'ShopController@inactive_products')->name('inactive_products');
    Route::get('/product/stock/{date}/{product_id}/{stock_quantity}/{price}', 'ShopController@store_stock')->name('store_stock');
    Route::get('/product/findsales/{product_id}', 'ShopController@findsales_quantity')->name('findsales_quantity');
    Route::get('/instock-products', 'ShopController@instock_products')->name('instock_products');
    Route::get('/need-to-add-stock-products', 'ShopController@need_to_add_stock_products')->name('need_to_add_stock_products');

    Route::get('/shop-order', 'ShopController@admin_custom_order')->name('admin_custom_order');
    Route::get('/products/findsales/{product_id}', 'ShopController@findsales_quantity')->name('findsales_quantity');
    Route::get('/order/custom-order/{id}', 'ShopController@single_custom_order')->name('single_custom_order');
    Route::post('/order/custom_product_add', 'ShopController@custom_order_product')->name('custom_product');
    Route::get('/order/custom-order/{order_id}/{product_id}/{amount}', 'ShopController@custom_order')->name('custom_order');



    Route::post('/create-shop-order', 'OrderController@create_shop_order')->name('create_shop_order');
  

    Route::get('/order/{id}', 'ShopController@single_order')->name('single_order');

    Route::get('/today-orders', 'ShopController@today_orders')->name('today_orders');
    Route::get('/orders', 'ShopController@order_index')->name('order');

//    Route::get('/today-orders/{date}', 'HomeController@previous_day_orders')->name('previous_day_orders');
    Route::get('/today-orders/delivered/{date}', 'ShopController@today_delivered_orders')->name('today_delivered_orders');
    Route::get('/order/print/{id}', 'ShopController@single_order_print')->name('single_order_print');
    Route::post('/order/order_status', 'ShopController@order_status')->name('order_status');
    Route::post('/order/customer-order-received-status', 'ShopController@customer_order_received_status_update')->name('customer_order_received_status_update');
    Route::get('/expire-products', 'ShopController@expire_products_show');


    Route::get('/order/update-shipping/{order_id}/{address}/{customer_name}', 'OrderController@shop_update_shipping')->name('shop_update_shipping');
    Route::get('/order/update-note/{order_id}/{note}', 'ShopController@update_note')->name('update_note');
    Route::get('/order-product-buy-price-update/{order_id}/{product_id}/{buy_price}', 'ShopController@order_product_buy_price_update')->name('order_product_buy_price_update');
    Route::get('/products/update-expire-date/{id}/{date}', 'ShopController@update_expire_date');








});


Route::group(['prefix' => 'ad', 'middleware' => ['admin']], function () {

    
     Route::get('/daily', 'HomeController@daily_sale')->name('daily_sale');
 Route::get('/monthly', 'HomeController@monthly_sale')->name('monthly_sale');
Route::get('/cancel-order', 'HomeController@cancel_order')->name('cancel_order');
 
    Route::get('/delete-category/{id}', 'HomeController@delete_category')->name('delete_category');
    Route::get('/delete-product/{id}', 'HomeController@delete_product')->name('delete_product');

    Route::get('/delete-subcategory/{id}', 'HomeController@delete_subcategory')->name('delete_subcategory');
    Route::get('/delete-childcategory/{id}', 'HomeController@delete_childcategory')->name('delete_childcategory');


    Route::get('/clean-history', 'brandController@stock_history')->name('stock_history');
    Route::post('/stock-history-clean', 'brandController@stock_history_clean')->name('stock_history_clean');
    Route::post('/save-employee', 'AttendanceController@save_employee')->name('save_employee');
    Route::get('/edit-employee/{id}', 'AttendanceController@edit_employee')->name('edit_employee');
    Route::post('/update-employee', 'AttendanceController@update_employee')->name('update_employee');
    Route::post('/product-lock', 'brandController@product_lock')->name('product_lock');
    Route::get('/water-receipt', 'waterController@water_receipt')->name('water_receipt');
    Route::get('/water-orders', 'waterController@water_today_orders')->name('water_today_orders');


    //shop order
    //shop money  invest

    //shop money  invest


    Route::get('/temp-instock-products', 'HomeController@temp_instock_products')->name('temp_instock_products');
    Route::get('/map-location', 'HomeController@map_location')->name('map_location');
    Route::get('/map-location/delete/{id}', 'HomeController@delete_map_location')->name('delete_map_location');
    Route::post('/map-location/store', 'HomeController@map_location_store')->name('map_location_store');

    Route::get('/temp-instock-products/{id}', 'HomeController@single_temp_instock_products')->name('single_temp_instock_products');

    Route::get('/products/update-expire-date/{id}/{date}', 'HomeController@update_expire_date')->name('update_expire_date');

    Route::get('/refered-Customers', 'AdminController@refered_customers')->name('refered_customers');


    Route::get('/sms', 'AdminController@sms')->name('sms');
    Route::get('/select-sms', 'AdminController@select_sms')->name('select_sms');
    Route::get('/expire-products', 'AdminController@expire_products_show');
    Route::get('/sms/{phone}/{status}', 'AdminController@assign_number')->name('assign_number');
    Route::post('/save-sms', 'AdminController@save_sms')->name('save_sms');
//    Route::post('/save-numbers', 'AdminController@save_numbers')->name('save_numbers');
    Route::get('/sms-history', 'AdminController@sms_history')->name('sms_history');
    Route::get('/temp-sms-history', 'AdminController@temp_sms_history')->name('temp_sms_history');
    Route::get('/test', 'waterController@test_for_qury')->name('test_for_qury');


    //daily summary  update
    Route::post('/daily-money-summary', 'HomeController@daily_money_summary')->name('daily_money_summary');

    Route::get('/expired-date', 'AdminController@expired_date')->name('expired_date');

//deposit
    Route::get('/customer-deposit', 'depositController@index')->name('customer_deposit');
    Route::post('/save-deposit', 'depositController@save_deposit')->name('save_deposit');
    Route::post('/purchase-from-deposit-money', 'depositController@purchase_from_deposit_money')->name('purchase_from_deposit_money');
    Route::get('/deposit-request-list', 'depositController@deposit_request_list')->name('deposit_request_list');
    Route::get('/deposit-request-list/{id}', 'depositController@deposit_checked')->name('deposit_checked');
    Route::get('/remaining-deposit-amount', 'depositController@remaining_deposit_amount')->name('remaining_deposit');

//Due customer

     Route::get('/due-customers', 'waterController@due_customers_index')->name('due_customers_index');
     Route::get('/due-customer/{id}', 'waterController@customers_due')->name('customers_due');
     Route::post('/add-due-customer', 'waterController@add_due_customer')->name('add_due_customer');


    //delivery  boy add

    Route::get('/new-delivery-boy', 'DeliveryLocationController@new_delivery_boy')->name('new_delivery_boy');
    Route::get('/my-delivery', 'DeliveryLocationController@my_delivery')->name('my_delivery');
    Route::get('/my-delivery/{delivery_boy_id}/{start_date}/{end_date}', 'DeliveryLocationController@get_my_delivery')->name('get_my_delivery');
    Route::get('/edit_delivery_boy/{id}', 'DeliveryLocationController@edit_delivery_boy')->name('edit_delivery_boy');
    Route::post('/save-delivery-boy', 'DeliveryLocationController@save_delivery_boy')->name('save_delivery_boy');
    Route::post('/update-delivery-boy', 'DeliveryLocationController@update_delivery_boy')->name('update_delivery_boy');

//trash

    Route::get('/trash', 'AdminController@trash')->name('trash');
    Route::post('/save_trash', 'AdminController@save_trash')->name('save_trash');

    //stock money  manage
    Route::get('/stock-money', 'AdminController@manage_stock_money')->name('manage_stock_money');
    Route::post('/save-stock-manage', 'AdminController@save_stock_manage')->name('save_stock_manage');

//investment
    Route::get('/invest', 'AdminController@index')->name('invest  form');
    Route::post('/save-invest', 'AdminController@save_invest')->name('save_invest');


    Route::get('/affiliate/users', 'OrderController@marketer_user_list')->name('marketer_user_list');
    Route::post('/affiliate-user-activity', 'OrderController@marketer_order_activity_admin_view')->name('marketer_order_activity_admin_view');

    Route::get('/affiliate/customer', 'UserController@assign_affiliate_customer')->name('assign_affiliate_customer');
    Route::get('/affiliate/sales_calculate', 'UserController@affiliate_sales_calculate')->name('affiliate_sales_calculate');
    Route::post('/affiliate/customer/add', 'UserController@add_affiliate_customer')->name('add_affiliate_customer');

    Route::post('/customer-activity-search/{number}', 'UserController@affiliate_customer_activity_search')->name('affiliate_customer_activity_search');


    Route::post('/order/product-customize', 'OrderController@customize_order_product')->name('customize_order_product');
    Route::post('/order/customer-order-received-status', 'OrderController@customer_order_received_status')->name('customer_order_received_status');

    Route::get('/temp-products-stock', 'HomeController@temp_products_stock')->name('temp_products_stock');
    Route::get('/temp-products-stock-verify', 'HomeController@temp_products_stock_verify')->name('temp_products_stock_verify');
    Route::get('/temp-instock-products-delete/{id}', 'HomeController@temp_instock_products_delete')->name('temp_instock_products_delete');

    Route::get('/products/stock', 'HomeController@stock_index')->name('stock_index');

    Route::get('/products/stock/{date}/{product_id}/{stock_quantity}/{price}', 'HomeController@store_stock')->name('store_stock');
    Route::get('/products/temp-stock/{date}/{product_id}/{stock_quantity}/{price}', 'HomeController@temp_store_stock')->name('temp_store_stock');

    Route::get('/products/findsales/{product_id}', 'HomeController@findsales_quantity')->name('findsales_quantity');
    Route::post('/search-stock', 'HomeController@search_stock')->name('search_stock');
    //admin custom order
    Route::get('/admin-custom-order', 'OrderController@admin_custom_order')->name('admin_custom_order');
    Route::post('/admin-order', 'OrderController@admin_order')->name('admin_order');


    Route::get('/inactive_customers', 'waterController@inactive_customers');
    Route::get('/disable-water-customers', 'waterController@disable_water_customers');
    Route::get('/all-inactive-customers', 'waterController@all_inactive_customers');


    Route::get('/waiting-stock-list', 'waterController@waiting_stock_list');
    Route::get('/save_waiting_list/{id}/{quantity}/{total_price}', 'waterController@save_waiting_list')->name('save_waiting_list');
    Route::get('/del_waiting_list/{id}', 'waterController@del_waiting_list')->name('del_waiting_list');




    Route::get('/water-customer-comment/{phone}/{comment}', 'waterController@water_customer_comment')->name('water_customer_comment');
    Route::get('/waters', 'waterController@index')->name('wa_index');
    Route::get('/waters/{id}', 'waterController@customer_history')->name('customer_history');
    Route::get('/waters/sell/{customer_id}/{date}/{sell_amount}', 'waterController@sell_water')->name('sell_water');
    Route::get('/waters/collect/{customer_id}/{date}/{get_bottle}', 'waterController@collect_water_jar')->name('collect_water_jar');
    Route::post('/updatewaterfromorder', 'waterController@updateWaterFromOrder')->name('updateWaterFromOrder');

    Route::post('/save_water_customer', 'waterController@save_water_customer')->name('save_water_customer');
    Route::get('/water_customer/lists', 'waterController@show_water_customer')->name('show_water_customer');
    Route::get('/water_customer/lists/print', 'waterController@print_water_customer')->name('print_water_customer');
    Route::get('/water_customer/{id}', 'waterController@edit_water_customer')->name('edit_water_customer');
    Route::post('/update_water_customer', 'waterController@update_water_customer')->name('update_water_customer');


    Route::get('/waters/comment/{customer_id}/{date}/{comment}', 'waterController@comment')->name('comment');

    Route::get('/waters/collect-price/{customer_id}/{jarprice}', 'waterController@water_price')->name('water_price');
    Route::get('/waters/dispancer/{customer_id}/{tota_dis_jar}', 'waterController@tota_dis_jar')->name('tota_dis_jar');


    Route::get('/other-income/{start_date}/{end_date}', 'HomeController@other_income_calculation')->name('other_income_calculation');


    Route::get('/add-unit', 'HomeController@unit_form')->name('unit_form');
    Route::post('/save_unit', 'HomeController@save_unit')->name('save_unit');

    Route::get('/vendor-request', 'HomeController@vendor_requests')->name('vendor_requests_list');
    Route::get('/vendor-request/{id}', 'HomeController@check_vendor_status')->name('check_vendor_status');


    Route::get('/best-buy-customers', 'OrderController@best_buy_customers')->name('best_buy_customers');

    //Start Restaurent
    Route::get('/restaurants', 'RestaurantController@index')->name('res_index');
    Route::post('/restaurants/create', 'RestaurantController@create')->name('res_create');
    Route::get('/restaurants/lists', 'RestaurantController@lists')->name('res_list');
    Route::get('/restaurants/{id}', 'RestaurantController@show')->name('single_res');
    Route::post('/restaurants/update_restaurent', 'RestaurantController@update_restaurent')->name('update_restaurent');


    Route::get('/foods', 'RestaurantController@food_form')->name('food_form');
    Route::get('/foods/{id}', 'RestaurantController@edit_food')->name('edit_food');
    Route::get('/food-list', 'RestaurantController@food_lists')->name('food_lists');

    Route::post('/create_food', 'RestaurantController@create_food')->name('create_food');
    Route::post('/update_food', 'RestaurantController@update_food')->name('update_food');


    //End Restaurent


    Route::get('/users', 'UserController@all_users')->name('all_users');
    Route::get('/customers', 'UserController@customers')->name('customers');
    Route::get('/new-user', 'UserController@new_user')->name('new_user');
    Route::post('/save-user', 'UserController@save_user')->name('save_user');


    Route::get('/assign-marketer', 'UserController@assign_marketer')->name('assign_marketer');

    Route::post('/add-marketer-coupon', 'UserController@save_marketer')->name('save_marketer');


    Route::get('/users/{id}', 'UserController@single_user')->name('single_user');
    Route::post('/users/update-user', 'UserController@update_single_user')->name('update_single_user');


    Route::get('/banner', 'bannerController@index')->name('index_banner');
    Route::get('/banner-add', 'bannerController@store')->name('store');
    Route::get('/banner/{id}', 'bannerController@delete')->name('delete');
    Route::post('/create-banner', 'bannerController@create_banner')->name('create_banner');


    Route::get('/popup', 'HomeController@popup')->name('popup');
    Route::post('/update-offer', 'HomeController@update_offer')->name('update_offer');

    Route::get('/terms-condition', 'HomeController@terms')->name('terms');
    Route::post('/update-terms', 'HomeController@update_terms')->name('terms');

    Route::get('/request-list', 'HomeController@request_list')->name('request_list');

    Route::get('/request/{id}', 'HomeController@request_update')->name('request_update');


    Route::get('/expense-category', 'ExpenseController@expense_category')->name('expense_category');
    Route::post('/save-expense-category', 'ExpenseController@save_expense_category')->name('save_expense_category');

    //Attendance
    Route::get('/attendance', 'AttendanceController@index')->name('a_index');
    Route::post('/employee-data', 'AttendanceController@parameter')->name('parameter');
    Route::get('/sheet/{emp_id}/{year}/{month}', 'AttendanceController@generate_sheet')->name('generate_sheet');
    Route::post('/sheet/update', 'AttendanceController@update_sheet')->name('update_sheet');


    //income
    Route::get('/other-income', 'ExpenseController@show_form')->name('new show_form');
    Route::post('/save-income', 'ExpenseController@save_income')->name('save_income');
    Route::get('/incomes', 'ExpenseController@income_list')->name('income_list');

    //asset
    Route::get('/assets', 'ExpenseController@asset_index')->name('asset_index');
    Route::post('/save-asset', 'ExpenseController@save_asset')->name('save_asset');


    Route::get('/expense', 'ExpenseController@index')->name('expense List');
    Route::get('/expense-calculate/{start_date}/{end_date}', 'ExpenseController@expense_calculate')->name('expense_calculate  ');

    Route::get('/add-expense', 'ExpenseController@create')->name('new expense');
    Route::post('/save-expense', 'ExpenseController@save_expense')->name('save expense');

    Route::get('/affiliate-payment-form', 'ExpenseController@affiliate_payment_form')->name('affiliate_payment_form');
    Route::post('/save-affiliate-pay', 'ExpenseController@affiliate_payment_save')->name('affiliate_payment_save');

    Route::post('/approve-expense/', 'ExpenseController@approve_expense')->name('approve expense');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/add-product', 'HomeController@add_product')->name('add_product');

    Route::get('/inactive', 'HomeController@inactive')->name('inactive');
    Route::get('/assign-real-stock', 'HomeController@assign_real_stock')->name('assign_real_stock');
    Route::get('/real-stock/{id}', 'HomeController@update_real_stock')->name('update_real_stock');
    Route::get('/inactive_update/{id}', 'HomeController@inactive_update')->name('inactive_update');

    Route::get('/new_location', 'DeliveryLocationController@new_location')->name('new_location');

    Route::get('/locations', 'DeliveryLocationController@index')->name('all_lists');
    Route::get('/location/{id}', 'DeliveryLocationController@show')->name('show_loc');
    Route::post('/update_location', 'DeliveryLocationController@update_location')->name('update_location');
    Route::post('/add_location', 'DeliveryLocationController@add_location')->name('add_location');

    //medicines
    Route::get('/medicines', 'HomeController@medicines_lists')->name('medicines_lists');
    Route::post('/search-medicines', 'HomeController@search_medicines')->name('search_medicines');
    Route::get('/add-medicine', 'HomeController@add_medicine')->name('add_medicine');
    Route::post('/save-medicine', 'HomeController@create_medicine')->name('create_medicine');
    Route::get('/medicine/{id}', 'HomeController@edit_medicine')->name('edit_medicine');
    Route::post('/update_medicine', 'HomeController@update_medicine')->name('update_medicine');

    Route::get('/prescriptions', 'HomeController@prescriptions_lists')->name('prescriptions_lists');
    Route::get('/order/serch-product/{value}', 'HomeController@serch_product')->name('serch_product');
    Route::get('/prescription-checked/{id}', 'HomeController@prescriptions_checked')->name('prescriptions_checked');


    Route::get('/products', 'HomeController@product_lists')->name('product_lists');
    Route::get('/big-buy-price-products', 'HomeController@big_buy_price_products')->name('big_buy_price_products');

    Route::post('/create_product', 'HomeController@create_product')->name('create_product');
    Route::post('/update_product', 'HomeController@update_product')->name('update_product');

    Route::get('/products/{id}', 'HomeController@edit_product')->name('edit_product');

    Route::get('/regular-checking-products', 'HomeController@regular_checking_products')->name('regular_checking_products');

    Route::get('/instock-products', 'HomeController@instock_products')->name('instock_products');
    Route::get('/instock-products-list-light', 'HomeController@instock_product_lists_light')->name('instock_product_lists_light');
    Route::get('/buy-price-added-products', 'HomeController@buy_price_added_products')->name('buy_price_added_products');
    Route::get('/product-location', 'HomeController@product_location')->name('product_location');
    Route::get('/product-location/{product_id}/{rak_no}', 'HomeController@update_product_location')->name('update_product_location');
    Route::get('/stock-product-buy-price/{product_id}/{price}/{lowStockQuantity}', 'HomeController@instock_product_buy_price_update')->name('instock_product_buy_price_update');

    Route::get('/low-stock-products', 'HomeController@low_stock_products')->name('low_stock_products');


    Route::get('/regular_products', 'HomeController@regular_products')->name('regular_products');
    Route::get('/regular_products/{id}', 'HomeController@regular_products_toogle')->name('regular_products_toogle');
    Route::get('/regular_product_price_update/{id}/{price}/{discount}', 'HomeController@regular_product_price_update')->name('regular_product_price_update');

    Route::get('/category', 'HomeController@category')->name('create_category');
    Route::get('/category/{id}', 'CategoryController@edit_category')->name('edit_category');
    Route::post('/create_category', 'HomeController@create_category')->name('create_category');
    Route::post('/update_category', 'CategoryController@update_category')->name('update_category');
    Route::get('/category-lists', 'HomeController@category_lists')->name('category_lists');

    Route::get('/sales-calculation/{start_date}/{end_date}', 'HomeController@sales_calculation')->name('sales_calculation');


    Route::get('/sub-category', 'HomeController@sub_category')->name('sub_category');
    Route::post('/create_sub_categories', 'HomeController@create_sub_categories')->name('create_sub_categories');
    Route::get('/sub-category-lists', 'HomeController@sub_category_lists')->name('sub_category_lists');
    Route::get('/sub_category/{id}', 'SubCategoryController@edit_sub_category')->name('edit_sub_category');
    Route::post('/update_sub_category', 'SubCategoryController@update_sub_category')->name('update_sub_category');


    Route::get('/child-category', 'ChildSubCatsController@index')->name('Child_category');
    Route::post('/create_child_category', 'ChildSubCatsController@create')->name('create_child_category');
    Route::get('/child-cat-list', 'ChildSubCatsController@child_category_lists')->name('child_category_lists');
    Route::get('/child_category/{id}', 'ChildSubCatsController@edit_child_category')->name('edit_child_category');
    Route::post('/update_child_category', 'ChildSubCatsController@update_child_category')->name('update_child_category');


    Route::get('/brand', 'brandController@index')->name('brand');
    Route::post('/create_brand', 'brandController@create_brand')->name('create_brand');
    Route::get('/brand/{id}', 'brandController@edit_brand')->name('edit_brand');
    Route::get('/brand/delete/{id}', 'brandController@delete_brand')->name('delete_brand');
  
    Route::get('/brand-lists', 'brandController@brand_lists')->name('brand_lists');
    Route::post('/update_brand', 'brandController@update_brand')->name('update_brand');

    Route::get('/orders-light', 'HomeController@order_lists_light')->name('order_lists_light');
    Route::get('/orders', 'HomeController@order_index')->name('order');
    Route::get('/today-orders', 'HomeController@today_orders')->name('today_orders');
    Route::get('/dayend-sold-products/{date}', 'HomeController@dayend_sold_products')->name('dayend_sold_products');
    Route::get('/today-orders/{date}', 'HomeController@previous_day_orders')->name('previous_day_orders');
    Route::get('/today-orders/delivered/{date}', 'HomeController@today_delivered_orders')->name('today_delivered_orders');

    Route::get('/order/{id}', 'HomeController@single_order')->name('single_order');
    Route::get('/order/update-shipping/{order_id}/{address}/{customer_name}', 'HomeController@update_shipping')->name('update_shipping');
    Route::get('/order/update-note/{order_id}/{note}', 'HomeController@update_note')->name('update_note');

    Route::get('/order/admin-custom-order-product-increase/{order_id}/{product_id}/{old_quantity}/{new_quantity}/{unitPrice}', 'OrderController@admin_custom_order_product_increase')->name('admin_custom_order_product_increase');
    Route::get('/order/admin-custom-order-product-decrease/{order_id}/{product_id}/{old_quantity}/{new_quantity}/{unitPrice}', 'OrderController@admin_custom_order_product_decrease')->name('admin_custom_order_product_decrease');


    Route::get('/order/custom-order/{id}', 'HomeController@single_order_test')->name('single_order_custom');
    Route::get('/order/print/{id}', 'HomeController@single_order_print')->name('single_order_print');
    Route::get('/order/print-en/{id}', 'HomeController@single_order_en_print')->name('single_order_en_print');


    Route::get('/order/order_buy_price_print/{id}', 'HomeController@order_buy_price_print')->name('order_buy_price_print');
    Route::post('/order/order_status', 'HomeController@order_status')->name('order_status');
    Route::get('/order-product-buy-price-update/{order_id}/{product_id}/{buy_price}', 'HomeController@order_product_buy_price_update')->name('order_product_buy_price_update');

    Route::get('/order/custom-order/{order_id}/{product_id}/{amount}', 'HomeController@custom_order')->name('custom_order');
    Route::get('/order/custom-product-add/{order_id}/{product_id}/{quantity}/{product_price}', 'HomeController@custom_order_product')->name('custom_product');
    Route::post('/order/custom_product_add', 'HomeController@custom_order_product')->name('custom_product');

    Route::get('/coupon-lists', 'CouponController@coupon_lists')->name('coupon_lists');
    Route::get('/used-coupon', 'CouponController@used_coupon')->name('used_coupon');
    Route::get('/remove-used-coupon/{id}', 'CouponController@remove_used_coupon')->name('remove_used_coupon');
    Route::get('/new-coupon', 'CouponController@new_coupon')->name('new_coupon');
    Route::post('/save-coupon', 'CouponController@save_coupon')->name('save_coupon');
    Route::get('/edit-coupon/{id}', 'CouponController@edit_coupon')->name('edit_coupon');
    Route::post('/update-coupon', 'CouponController@update_coupon')->name('update_coupon');

    Route::get('/salary-list', 'CouponController@salary_list')->name('salary_list');


    Route::get('/damage-list', 'waterController@damage_stock_list');
    Route::get('/save-damage/{id}/{quantity}/{total_price}', 'waterController@save_damage_list');

//    Route::post('/save_waiting_list', 'waterController@save_waiting_list')->name('save_waiting_list');
    Route::get('/del_damage_list/{id}', 'waterController@del_damage_list');


});

Route::group(['prefix' => 'pm', 'middleware' => ['manager']], function () {
    Route::get('/delete-category/{id}', 'HomeController@delete_category')->name('delete_category');
    Route::get('/delete-subcategory/{id}', 'HomeController@delete_subcategory')->name('delete_subcategory');
    Route::get('/delete-childcategory/{id}', 'HomeController@delete_childcategory')->name('delete_childcategory');


    Route::get('/temp-products-stock', 'HomeController@temp_products_stock')->name('temp_products_stock');
    Route::get('/temp-products-stock-verify', 'HomeController@temp_products_stock_verify')->name('temp_products_stock_verify');
    Route::get('/temp-instock-products-delete/{id}', 'HomeController@temp_instock_products_delete')->name('temp_instock_products_delete');


    Route::get('/sales-calculation/{start_date}/{end_date}', 'HomeController@sales_calculation')->name('sales_calculation');

    Route::get('/vendor-request', 'HomeController@vendor_requests')->name('vendor_requests_list');
    Route::get('/vendor-request/{id}', 'HomeController@check_vendor_status')->name('check_vendor_status');

    Route::get('/new-delivery-boy', 'DeliveryLocationController@new_delivery_boy')->name('new_delivery_boy');
    Route::get('/my-delivery', 'DeliveryLocationController@my_delivery')->name('my_delivery');


    Route::get('/instock-products-list-light', 'HomeController@instock_product_lists_light')->name('instock_product_lists_light');
    Route::get('/orders-light', 'HomeController@order_lists_light')->name('order_lists_light');
    Route::get('/water-orders', 'waterController@water_today_orders')->name('water_today_orders');

    Route::get('/water-receipt', 'waterController@water_receipt')->name('water_receipt');

    Route::get('/damage-list', 'waterController@damage_stock_list');
    Route::get('/save-damage/{id}/{quantity}/{total_price}', 'waterController@save_damage_list');

//    Route::post('/save_waiting_list', 'waterController@save_waiting_list')->name('save_waiting_list');
    Route::get('/del_damage_list/{id}', 'waterController@del_damage_list');



    Route::get('/map-location', 'HomeController@map_location')->name('map_location');
    Route::get('/map-location/delete/{id}', 'HomeController@delete_map_location')->name('delete_map_location');
    Route::post('/map-location/store', 'HomeController@map_location_store')->name('map_location_store');

    Route::get('/expired-date', 'AdminController@expired_date')->name('expired_date');

    //deposit

    Route::get('/water_customer/lists/print', 'waterController@print_water_customer')->name('print_water_customer');
    Route::get('/deposit-request-list', 'depositController@deposit_request_list')->name('deposit_request_list');
    Route::get('/remaining-deposit-amount', 'depositController@remaining_deposit_amount')->name('remaining_deposit');



    Route::post('/daily-money-summary', 'HomeController@daily_money_summary')->name('daily_money_summary');
    Route::get('/today-orders/delivered/{date}', 'HomeController@today_delivered_orders')->name('today_delivered_orders');
    Route::get('/dayend-sold-products/{date}', 'HomeController@dayend_sold_products')->name('dayend_sold_products');
    Route::get('/disable-water-customers', 'waterController@disable_water_customers');

//Due customer

    Route::get('/due-customers', 'waterController@due_customers_index')->name('due_customers_index');
    Route::get('/due-customer/{id}', 'waterController@customers_due')->name('customers_due');
    Route::post('/add-due-customer', 'waterController@add_due_customer')->name('add_due_customer');



    Route::get('/inactive_customers', 'waterController@inactive_customers');
    Route::get('/all-inactive-customers', 'waterController@all_inactive_customers');

    Route::get('/waiting-stock-list', 'waterController@waiting_stock_list');
    Route::get('/save_waiting_list/{id}/{quantity}/{total_price}', 'waterController@save_waiting_list')->name('save_waiting_list');

//    Route::post('/save_waiting_list', 'waterController@save_waiting_list')->name('save_waiting_list');
    Route::get('/del_waiting_list/{id}', 'waterController@del_waiting_list')->name('del_waiting_list');


    //Attendance
    Route::get('/attendance', 'AttendanceController@index')->name('a_index');
    Route::post('/employee-data', 'AttendanceController@parameter')->name('parameter');
    Route::get('/sheet/{emp_id}/{year}/{month}', 'AttendanceController@generate_sheet')->name('generate_sheet');
    Route::post('/sheet/update', 'AttendanceController@update_sheet')->name('update_sheet');

    Route::get('/low-stock-products', 'HomeController@low_stock_products')->name('low_stock_products');


    Route::post('/updatewaterfromorder', 'waterController@updateWaterFromOrder')->name('updateWaterFromOrder');


    Route::post('/order/product-customize', 'OrderController@customize_order_product')->name('customize_order_product');

    Route::post('/order/customer-order-received-status', 'OrderController@customer_order_received_status')->name('customer_order_received_status');

    Route::post('/admin-order', 'OrderController@admin_order')->name('admin_order');
    Route::get('/admin-custom-order', 'OrderController@admin_custom_order')->name('admin_custom_order');



    Route::get('/water-customer-comment/{phone}/{comment}', 'waterController@water_customer_comment')->name('water_customer_comment');
    Route::post('/save_water_customer', 'waterController@save_water_customer')->name('save_water_customer');
    Route::get('/water_customer/lists', 'waterController@show_water_customer')->name('show_water_customer');
    Route::get('/water_customer/{id}', 'waterController@edit_water_customer')->name('edit_water_customer');
    Route::post('/update_water_customer', 'waterController@update_water_customer')->name('update_water_customer');

    Route::get('/product-location', 'HomeController@product_location')->name('product_location');
    Route::get('/product-location/{product_id}/{rak_no}', 'HomeController@update_product_location')->name('update_product_location');


    Route::get('/waters/comment/{customer_id}/{date}/{comment}', 'waterController@comment')->name('comment');

    Route::get('/waters/collect-price/{customer_id}/{jarprice}', 'waterController@water_price')->name('water_price');
    Route::get('/waters/dispancer/{customer_id}/{tota_dis_jar}', 'waterController@tota_dis_jar')->name('tota_dis_jar');


    Route::get('/waters', 'waterController@index')->name('wa_index');
    Route::get('/waters/{id}', 'waterController@customer_history')->name('customer_history');
    Route::get('/waters/sell/{customer_id}/{date}/{sell_amount}', 'waterController@sell_water')->name('sell_water');
    Route::get('/waters/collect/{customer_id}/{date}/{get_bottle}', 'waterController@collect_water_jar')->name('collect_water_jar');

    Route::post('/save_water_customer', 'waterController@save_water_customer')->name('save_water_customer');
    Route::get('/water_customer/lists', 'waterController@show_water_customer')->name('show_water_customer');


    Route::get('/add-unit', 'HomeController@unit_form')->name('unit_form');
    Route::post('/save_unit', 'HomeController@save_unit')->name('save_unit');


    //Start Restaurent
    Route::get('/restaurants', 'RestaurantController@index')->name('res_index');
    Route::post('/restaurants/create', 'RestaurantController@create')->name('res_create');
    Route::get('/restaurants/lists', 'RestaurantController@lists')->name('res_list');
    Route::get('/restaurants/{id}', 'RestaurantController@show')->name('single_res');
    Route::post('/restaurants/update_restaurent', 'RestaurantController@update_restaurent')->name('update_restaurent');


    Route::get('/foods', 'RestaurantController@food_form')->name('food_form');
    Route::get('/foods/{id}', 'RestaurantController@edit_food')->name('edit_food');
    Route::get('/food-list', 'RestaurantController@food_lists')->name('food_lists');

    Route::post('/create_food', 'RestaurantController@create_food')->name('create_food');
    Route::post('/update_food', 'RestaurantController@update_food')->name('update_food');


    //End Restaurent


    Route::get('/instock-products', 'HomeController@instock_products')->name('instock_products');
    Route::get('/buy-price-added-products', 'HomeController@buy_price_added_products')->name('buy_price_added_products');

    //new add
    Route::get('/medicines', 'HomeController@medicines_lists')->name('medicines_lists');
    Route::post('/search-medicines', 'HomeController@search_medicines')->name('search_medicines');
    Route::get('/add-medicine', 'HomeController@add_medicine')->name('add_medicine');
    Route::post('/save-medicine', 'HomeController@create_medicine')->name('create_medicine');
    Route::get('/medicine/{id}', 'HomeController@edit_medicine')->name('edit_medicine');
    Route::post('/update_medicine', 'HomeController@update_medicine')->name('update_medicine');


    Route::get('/prescriptions', 'HomeController@prescriptions_lists')->name('prescriptions_lists');
    Route::get('/prescription-checked/{id}', 'HomeController@prescriptions_checked')->name('prescriptions_checked');
    Route::get('/order/serch-product/{value}', 'HomeController@serch_product')->name('serch_product');


    Route::get('/banner', 'bannerController@index')->name('index_banner');
    Route::get('/banner-add', 'bannerController@store')->name('store');
    Route::get('/banner/{id}', 'bannerController@delete')->name('delete');
    Route::post('/create-banner', 'bannerController@create_banner')->name('create_banner');


    Route::get('/expense', 'ExpenseController@index')->name('expense List');
    Route::get('/add-expense', 'ExpenseController@create')->name('create_expense');
    Route::post('/save-expense', 'ExpenseController@save_expense')->name('save expense');

    //Route::post('/manager-save-expense', 'ExpenseController@manager_save_expense')->name('manager_save_expense');

    Route::get('/', 'HomeController@manager_index')->name('Manager home');

    Route::get('/add-product', 'HomeController@add_product')->name('add_product');

    Route::get('/inactive', 'HomeController@inactive')->name('inactive');
    Route::get('/inactive_update/{id}', 'HomeController@inactive_update')->name('inactive_update');


    Route::get('/request-list', 'HomeController@request_list')->name('request_list');
    Route::get('/request/{id}', 'HomeController@request_update')->name('request_update');

    //Route::get('/new_location', 'DeliveryLocationController@new_location')->name('new_location');

    //Route::get('/locations', 'DeliveryLocationController@index')->name('all_lists');
    //Route::get('/location/{id}', 'DeliveryLocationController@show')->name('show_loc');
    //Route::post('/update_location', 'DeliveryLocationController@update_location')->name('update_location');
    //Route::post('/add_location', 'DeliveryLocationController@add_location')->name('add_location');

    Route::get('/products', 'HomeController@product_lists')->name('product_lists');
    Route::post('/create_product', 'HomeController@create_product')->name('create_product');
    Route::post('/update_product', 'HomeController@update_product')->name('update_product');

    Route::get('/products/{id}', 'HomeController@edit_product')->name('edit_product');



   Route::get('/product/stock', 'HomeController@stock_index')->name('stock_index');
    Route::get('/products/stock/{date}/{product_id}/{stock_quantity}/{price}', 'HomeController@store_stock')->name('store_stock');
    Route::get('/products/update-expire-date/{id}/{date}', 'HomeController@update_expire_date')->name('update_expire_date');
    Route::get('/products/findsales/{product_id}', 'HomeController@findsales_quantity')->name('findsales_quantity');
    Route::post('/search-stock', 'HomeController@search_stock')->name('search_stock');



    Route::get('/category', 'HomeController@category')->name('create_category');
    Route::get('/category/{id}', 'CategoryController@edit_category')->name('edit_category');
    Route::post('/create_category', 'HomeController@create_category')->name('create_category');
    Route::post('/update_category', 'CategoryController@update_category')->name('update_category');
    Route::get('/category-lists', 'HomeController@category_lists')->name('category_lists');


    Route::get('/sub-category', 'HomeController@sub_category')->name('sub_category');
    Route::post('/create_sub_categories', 'HomeController@create_sub_categories')->name('create_sub_categories');
    Route::get('/sub-category-lists', 'HomeController@sub_category_lists')->name('sub_category_lists');
    Route::get('/sub_category/{id}', 'SubCategoryController@edit_sub_category')->name('edit_sub_category');
    Route::post('/update_sub_category', 'SubCategoryController@update_sub_category')->name('update_sub_category');


    Route::get('/child-category', 'ChildSubCatsController@index')->name('Child_category');
    Route::post('/create_child_category', 'ChildSubCatsController@create')->name('create_child_category');
    Route::get('/child-cat-list', 'ChildSubCatsController@child_category_lists')->name('child_category_lists');
    Route::get('/child_category/{id}', 'ChildSubCatsController@edit_child_category')->name('edit_child_category');
    Route::post('/update_child_category', 'ChildSubCatsController@update_child_category')->name('update_child_category');


    Route::get('/brand', 'brandController@index')->name('brand');
    Route::post('/create_brand', 'brandController@create_brand')->name('create_brand');
    Route::get('/brand/{id}', 'brandController@edit_brand')->name('edit_brand');
    Route::get('/brand-lists', 'brandController@brand_lists')->name('brand_lists');
    Route::post('/update_brand', 'brandController@update_brand')->name('update_brand');

    Route::get('/order/custom-order/{id}', 'HomeController@single_order_test')->name('single_order_custom');
    Route::get('/order/print/{id}', 'HomeController@single_order_print')->name('single_order_print');
    Route::get('/order/print-en/{id}', 'HomeController@single_order_en_print')->name('single_order_en_print');


    Route::get('/order/order_buy_price_print/{id}', 'HomeController@order_buy_price_print')->name('order_buy_price_print');
    Route::post('/order/order_status', 'HomeController@order_status')->name('order_status');

    Route::get('/orders', 'HomeController@order_index')->name('order');
    Route::get('/today-orders', 'HomeController@today_orders')->name('today_orders');
    Route::get('/today-orders/{date}', 'HomeController@previous_day_orders')->name('previous_day_orders');

    Route::get('/order/{id}', 'HomeController@single_order')->name('single_order');
    Route::get('/order/update-shipping/{order_id}/{address}/{customer_name}', 'HomeController@update_shipping')->name('update_shipping');
    Route::get('/order/update-note/{order_id}/{note}', 'HomeController@update_note')->name('update_note');

    Route::get('/order-product-buy-price-update/{order_id}/{product_id}/{buy_price}', 'HomeController@order_product_buy_price_update')->name('order_product_buy_price_update');

    Route::get('/order/admin-custom-order-product-increase/{order_id}/{product_id}/{old_quantity}/{new_quantity}/{unitPrice}', 'OrderController@admin_custom_order_product_increase')->name('admin_custom_order_product_increase');
    Route::get('/order/admin-custom-order-product-decrease/{order_id}/{product_id}/{old_quantity}/{new_quantity}/{unitPrice}', 'OrderController@admin_custom_order_product_decrease')->name('admin_custom_order_product_decrease');


    //Route::get('/order/print/{id}', 'HomeController@single_order_print')->name('single_order_print');
    //Route::post('/order/order_status', 'HomeController@order_status')->name('order_status');


    Route::get('/order/custom-order/{order_id}/{product_id}/{amount}', 'HomeController@custom_order')->name('custom_order');
    Route::get('/order/custom-product-add/{order_id}/{product_id}/{quantity}/{product_price}', 'HomeController@custom_order_product')->name('custom_product');
    Route::post('/order/custom_product_add', 'HomeController@custom_order_product')->name('custom_product');

    Route::get('/regular-checking-products', 'HomeController@regular_checking_products')->name('regular_checking_products');
    Route::get('/regular_products', 'HomeController@regular_products')->name('regular_products');
    Route::get('/regular_products/{id}', 'HomeController@regular_products_toogle')->name('regular_products_toogle');

    Route::get('/regular_product_price_update/{id}/{price}/{discount}', 'HomeController@regular_product_price_update')->name('regular_product_price_update');


});

Route::group(['prefix' => 'au', 'middleware' => ['author']], function () {

    Route::get('/products/temp-stock/{date}/{product_id}/{stock_quantity}/{price}', 'HomeController@temp_store_stock')->name('temp_store_stock');

    Route::get('/products/findsales/{product_id}', 'HomeController@findsales_quantity')->name('findsales_quantity');
    Route::get('/temp-products-stock', 'HomeController@temp_products_stock')->name('temp_products_stock');
    Route::get('/temp-instock-products-delete/{id}', 'HomeController@temp_instock_products_delete')->name('temp_instock_products_delete');

    Route::get('/vendor-request', 'HomeController@vendor_requests')->name('vendor_requests_list');
    Route::get('/vendor-request/{id}', 'HomeController@check_vendor_status')->name('check_vendor_status');

    Route::get('/orders-light', 'HomeController@order_lists_light')->name('order_lists_light');
    Route::get('/water_customer/lists/print', 'waterController@print_water_customer')->name('print_water_customer');
    Route::get('/water-orders', 'waterController@water_today_orders')->name('water_today_orders');

    //Start Restaurent
    Route::get('/restaurants', 'RestaurantController@index')->name('res_index');
    Route::post('/restaurants/create', 'RestaurantController@create')->name('res_create');
    Route::get('/restaurants/lists', 'RestaurantController@lists')->name('res_list');
    Route::get('/restaurants/{id}', 'RestaurantController@show')->name('single_res');
    Route::post('/restaurants/update_restaurent', 'RestaurantController@update_restaurent')->name('update_restaurent');


    Route::get('/foods', 'RestaurantController@food_form')->name('food_form');
    Route::get('/foods/{id}', 'RestaurantController@edit_food')->name('edit_food');
    Route::get('/food-list', 'RestaurantController@food_lists')->name('food_lists');

    Route::post('/create_food', 'RestaurantController@create_food')->name('create_food');
    Route::post('/update_food', 'RestaurantController@update_food')->name('update_food');


    //End Restaurent

    //medicines
    Route::get('/medicines', 'HomeController@medicines_lists')->name('medicines_lists');
    Route::post('/search-medicines', 'HomeController@search_medicines')->name('search_medicines');
    Route::get('/add-medicine', 'HomeController@add_medicine')->name('add_medicine');
    Route::post('/save-medicine', 'HomeController@create_medicine')->name('create_medicine');
    Route::get('/medicine/{id}', 'HomeController@edit_medicine')->name('edit_medicine');
    Route::post('/update_medicine', 'HomeController@update_medicine')->name('update_medicine');


    Route::get('/water-customer-comment/{phone}/{comment}', 'waterController@water_customer_comment')->name('water_customer_comment');
    Route::get('/waters/{id}', 'waterController@customer_history')->name('customer_history');
    Route::get('/inactive_customers', 'waterController@inactive_customers');
    Route::get('/water_customer/lists', 'waterController@show_water_customer')->name('show_water_customer');
    Route::get('/water_customer/{id}', 'waterController@edit_water_customer')->name('edit_water_customer');


    Route::get('/add-product', 'HomeController@add_product')->name('add_product');
    Route::post('/create_product', 'HomeController@create_product')->name('create_product');
    Route::get('/regular-checking-products', 'HomeController@regular_checking_products')->name('regular_checking_products');
    Route::get('/regular_product_price_update/{id}/{price}/{discount}', 'HomeController@regular_product_price_update')->name('regular_product_price_update');



    Route::get('/', 'HomeController@manager_index')->name('Order Manager home');


    Route::get('/inactive_customers', 'waterController@inactive_customers');
    Route::get('/all-inactive-customers', 'waterController@all_inactive_customers');

    Route::get('/low-stock-products', 'HomeController@low_stock_products')->name('low_stock_products');

    Route::post('/order/product-customize', 'OrderController@customize_order_product')->name('customize_order_product');

    Route::post('/order/customer-order-received-status', 'OrderController@customer_order_received_status')->name('customer_order_received_status');

    Route::post('/admin-order', 'OrderController@admin_order')->name('admin_order');
    Route::get('/admin-custom-order', 'OrderController@admin_custom_order')->name('admin_custom_order');

    Route::get('/waters', 'waterController@index')->name('wa_index');

    Route::post('/save_water_customer', 'waterController@save_water_customer')->name('save_water_customer');
    Route::get('/water_customer/lists', 'waterController@show_water_customer')->name('show_water_customer');

    Route::get('/prescriptions', 'HomeController@prescriptions_lists')->name('prescriptions_lists');
    Route::get('/prescription-checked/{id}', 'HomeController@prescriptions_checked')->name('prescriptions_checked');
    Route::get('/order/serch-product/{value}', 'HomeController@serch_product')->name('serch_product');


    Route::get('/request-list', 'HomeController@request_list')->name('request_list');
    Route::get('/request/{id}', 'HomeController@request_update')->name('request_update');

    Route::get('/products', 'HomeController@product_lists')->name('product_lists');

      Route::get('/order/print/{id}', 'HomeController@single_order_print')->name('single_order_print');
    Route::get('/order/print-en/{id}', 'HomeController@single_order_en_print')->name('single_order_en_print');


    Route::get('/order/order_buy_price_print/{id}', 'HomeController@order_buy_price_print')->name('order_buy_price_print');

    Route::get('/orders', 'HomeController@order_index')->name('order');
    Route::get('/today-orders', 'HomeController@today_orders')->name('today_orders');
    Route::get('/today-orders/{date}', 'HomeController@previous_day_orders')->name('previous_day_orders');
    Route::get('/today-orders/delivered/{date}', 'HomeController@today_delivered_orders')->name('today_delivered_orders');


    Route::get('/order/{id}', 'HomeController@single_order')->name('single_order');
    Route::get('/order/update-shipping/{order_id}/{address}/{customer_name}', 'HomeController@update_shipping')->name('update_shipping');
    Route::get('/order/update-note/{order_id}/{note}', 'HomeController@update_note')->name('update_note');



    Route::get('/order/custom-order/{id}', 'HomeController@single_order_test')->name('single_order_custom');
    Route::get('/order/print/{id}', 'HomeController@single_order_print')->name('single_order_print');
    Route::get('/order/print-en/{id}', 'HomeController@single_order_en_print')->name('single_order_en_print');


    Route::get('/order/order_buy_price_print/{id}', 'HomeController@order_buy_price_print')->name('order_buy_price_print');
    Route::post('/order/order_status', 'HomeController@order_status')->name('order_status');
    Route::get('/order-product-buy-price-update/{order_id}/{product_id}/{buy_price}', 'HomeController@order_product_buy_price_update')->name('order_product_buy_price_update');


    Route::get('/order/custom-order/{order_id}/{product_id}/{amount}', 'HomeController@custom_order')->name('custom_order');
    Route::get('/order/custom-product-add/{order_id}/{product_id}/{quantity}/{product_price}', 'HomeController@custom_order_product')->name('custom_product');
    Route::post('/order/custom_product_add', 'HomeController@custom_order_product')->name('custom_product');


});


Route::group(['prefix' => 've', 'middleware' => ['vendor']], function () {


    Route::get('/foods', 'RestaurantController@food_form')->name('food_form');
    Route::get('/foods/{id}', 'RestaurantController@edit_food')->name('edit_food');
    Route::get('/food-list', 'RestaurantController@vendor_food_lists')->name('vendor_food_lists');

    Route::post('/create_food', 'RestaurantController@create_food')->name('create_food');
    Route::post('/update_food', 'RestaurantController@update_food')->name('update_food');



    Route::get('/', 'HomeController@index')->name('Vendor home');

    Route::get('/add-product', 'HomeController@vendor_new_product')->name('vendor_new_product');
    Route::post('/vendor_create_product', 'HomeController@vendor_create_product')->name('vendor_create_product');
    Route::get('/vendor_product_list', 'HomeController@vendor_product_list')->name('vendor_product_list');
    Route::get('/products/{id}', 'HomeController@vendor_product_edit')->name('vendor_product_edit');
    Route::post('/vendor_product_update', 'HomeController@vendor_product_update')->name('vendor_product_update');

    //  Route::get('/brand', 'brandController@index')->name('brand');
//    Route::post('/create_brand', 'brandController@create_brand')->name('create_brand');
//    Route::get('/brand/{id}', 'brandController@edit_brand')->name('edit_brand');
//    Route::get('/brand-lists', 'brandController@brand_lists')->name('brand_lists');
//    Route::post('/update_brand', 'brandController@update_brand')->name('update_brand');

    Route::get('/orders', 'OrderController@vendor_order_list')->name('vendor_order_list');

});
