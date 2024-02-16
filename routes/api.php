<?php
use Illuminate\Http\Request;

//for admin panel
Route::get('/active-product-lists', 'ProductController@api_active_product_lists');
Route::get('/active-realstock-product-lists', 'ProductController@api_realstock_product_lists');
Route::get('/purchase-products', 'ProductController@purchase_products');
Route::post('/temp-products-final-update', 'ProductController@temp_products_final_update')->name('temp_products_final_update');
//end


Route::post('register', 'UserController@register_customer');
Route::post('send-otp-token', 'UserController@send_token');
Route::post('verify-otp-token', 'UserController@verify_OTP_token');

Route::get('/product-expires-list', 'AdminController@product_expires_list');

Route::get('/expire-products', 'AdminController@expire_products');
Route::get('/shop/expire-products', 'AdminController@shop_expire_products');

Route::get('/inactive-customer-lists', 'waterController@inactive_customers_list');
Route::get('/all-inactive-customer-lists', 'waterController@all_inactive_customers_list');

Route::get('/customer-orders/{id}', 'myOrderController@customer_orders_show');
//Route::get('/customer-deposit/{id}', 'myOrderController@customer_deposit');
Route::get('/deposit-history/{id}', 'depositController@deposit_history');
Route::get('/deposit-message', 'depositController@deposit_message');
Route::get('/deposit-refer-list/{user_id}', 'depositController@deposit_refer_list');
Route::post('/deposit-request', 'depositController@deposit_request');
Route::post('/add-reference', 'depositController@add_reference');

//forr admin use
Route::get('/admin_single_order/{id}', 'myOrderController@admin_single_order');
Route::post('/save_due_payment', 'myOrderController@save_due_payment');
Route::post('/receive_due_payment', 'myOrderController@receive_due_payment');


Route::get('/shipping/{phone}', 'OrderController@shipping_lists');
Route::get('/shop/shipping/{phone}', 'OrderController@shop_shipping_lists');

Route::get('/delivery-mans', 'myOrderController@delivery_mans');


Route::get('/marketer/{id}', 'OrderController@marketer_order_activity');

Route::get('/customer-order-items/{id}', 'myOrderController@customer_order_items');

Route::post('upload-prescription', 'CategoryController@upload_prescription');

Route::post('login', 'UserController@authenticate');


Route::get('open', 'DataController@open');
 Route::get('/all-category-lists', 'CategoryController@all_category');
 Route::get('/featured-products', 'CategoryController@featured');
 Route::get('/banners', 'CategoryController@banner');

//restaurant
Route::get('/restaurants', 'RestaurantController@all_restaurants');
Route::get('/restaurant/{id}', 'RestaurantController@get_foods');

  Route::get('/all-postcode', 'CategoryController@postcode');
  Route::get('/all-delivery-locations', 'CategoryController@all_delivery_locations');
  Route::get('/delivery-locations', 'CategoryController@all_locations');
  Route::get('/delivery-slot/{order_id}', 'CategoryController@delivery_slot');
  Route::get('/delivery-slot-update/{order_id}/{time_slot}', 'CategoryController@delivery_slot_update');
  Route::get('/delivery-locations/{userid}', 'CategoryController@all_locations_previous_address_used');

  Route::post('/update-profile',  'Api\ResetPasswordController@update_profile');

Route::get('/all-category-list', 'CategoryController@all_categories');
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
//    Route::post('update-profile', 'UserController@update_profile');

});

 Route::post('set-new-password', 'Api\ForgotPasswordController@set_new_password');
Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::get('coupons', 'CouponController@index');
Route::post('validate_coupon', 'CouponController@validate_coupon');
Route::post('validate_coupon_test', 'CouponController@validate_coupon_test');
Route::post('apply-job', 'AdminController@apply_job');

Route::get('banner', 'bannerController@get_list');
Route::get('banner/{name}', 'bannerController@banner_show');
Route::get('terms', 'bannerController@get_terms');

Route::apiResource('/orders', 'OrderController');
Route::post('/orders-test', 'OrderController@store_test');
Route::post('/add-address', 'OrderController@add_paddress');
Route::post('/delivery-address', 'OrderController@get_paddress');
Route::post('/delete-address', 'OrderController@delete_paddress');
Route::post('/default-address', 'OrderController@default_address');

Route::apiResource('/category', 'CategoryController');
 Route::post('product-request', 'ProductController@product_request');
 Route::post('vendor-request', 'ProductController@vendor_request');
 
Route::get('/testpagi/{id}', 'CategoryController@test_pagi');
Route::apiResource('/sub_category', 'SubCategoryController');
Route::get('/child_sub_category', 'ChildSubCatsController@show_child_categorie');

Route::get('/search-products/{id}', 'ProductController@search');

Route::get('/shop/search-products/{id}', 'ProductController@shop_product_search');
Route::get('/shop/admin-search-products/{id}', 'ProductController@admin_shop_product_search');

Route::apiResource('/products', 'ProductController');

//Route::get('/category_products/{id}', 'CategoryController@show_products');

Route::post('/cancel-order', 'myOrderController@cancel_order');

Route::get('/myorders/{id}', 'myOrderController@show');
Route::get('/myorder/{user_id}/{id}', 'myOrderController@single_order_detail');

Route::get('/myorders/{id}/items', 'myOrderController@order_items');

Route::get('/deposit-orders/{id}', 'myOrderController@deposit_order_show');
Route::get('/deposit-orders/{id}/items', 'myOrderController@deposit_order_items');

Route::group(['prefix' => 'products'], function () {
    Route::apiResource('/{product}/reviews', 'ReviewController');
    Route::apiResource('/{product}/rating', 'RatingController');
});
// Route::post('/password/phone', 'Api\ForgotPasswordController@sendOTPcode');
//Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
//for eamail  password  reset  just use email  field
Route::post('/password/reset', 'Api\ResetPasswordController@reset');
Route::post('/password/resetpassword', 'Api\ResetPasswordController@resetpassword');
//Route::group(['prefix' => 'category'], function () {
//    Route::apiResource('/{cat_id}', 'CategoryController');
//});