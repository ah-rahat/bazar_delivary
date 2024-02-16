<div class="left-area">
<!--<div id="navbar" class="navbar-collapse left-area collapse in" aria-expanded="true" style="">-->
<div class="left-humberger-menu ">
    <div class="sidebar">
        <a class="logo-area text-center" href="{{ url('/ad') }}">
            <img src="{{ url('/') }}/images/grasshopper-logo.png"   width="150px"  />
        </a>
        <span style="color: #000">NAVIGATION</span>

            <ul>
                <li> <a href="{{ url('ad') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#drop10" class="drop"> Orders <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>
                    <ul id="drop10" class="collapse">
                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('/ad') }}/admin-custom-order"><i class="fa fa-angle-right" aria-hidden="true"></i>  Create  Order</a>--}}
                        {{--                        </li>--}}
                        <li>
                            <a class="nav-link" href="{{ url('/ad') }}/today-orders"><i class="fa fa-angle-right" aria-hidden="true"></i>  Today Order's</a>
                        </li>
                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('ad/') }}/orders"><i class="fa fa-angle-right" aria-hidden="true"></i>  All Order Lists</a>--}}
                        {{--                        </li>--}}
                        <li>
                            <a class="nav-link" href="{{ url('/ad') }}/orders-light"><i class="fa fa-angle-right" aria-hidden="true"></i>  All Order Lists</a>
                        </li>
                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('/ad') }}/water-orders"><i class="fa fa-angle-right" aria-hidden="true"></i>  Water Order's</a>--}}
                        {{--                        </li>--}}
                        {{--                        <li>--}}
                        {{--                            <a target="_blank" class="nav-link" href="{{ url('/ad') }}/water-receipt"><i class="fa fa-angle-right" aria-hidden="true"></i> Print Water Receipt</a>--}}
                        {{--                        </li>--}}
                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('/ad') }}/dayend-sold-products/{{date('d-m-Y')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>  Today Sold Products</a>--}}
                        {{--                        </li>--}}
                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('/ad') }}/map-location"><i class="fa fa-angle-right" aria-hidden="true"></i>  MAP Locations</a>--}}
                        {{--                        </li>--}}
                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('ad/') }}/best-buy-customers"><i class="fa fa-angle-right" aria-hidden="true"></i>  Highest Order Customers</a>--}}
                        {{--                        </li>--}}
                    </ul>
                </li>
                <li > <a href="#" data-toggle="collapse" data-target="#drop1" class="drop" > Products <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop1" class="collapse">
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/temp-instock-products') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Temp Products List</a>--}}
{{--                        </li>--}}
                        <li>
                            <a class="nav-link" href="{{ url('ad/add-product') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Product</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/products"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Active  Product's</a>
                        </li>
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/temp-products-stock-verify"><i class="fa fa-angle-double-right" aria-hidden="true"></i>    Update Stock By verify</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/products/stock"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Direct  Update Stock</a>--}}
{{--                        </li>--}}


{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/instock-products-list-light"><i class="fa fa-angle-double-right" aria-hidden="true"></i> In Stock  Product's Light</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/instock-products"><i class="fa fa-angle-double-right" aria-hidden="true"></i> In Stock  Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/regular-checking-products"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Regular Checking Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/regular_products"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Regular Checking Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/product-location"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product's Loction In RAK</a>--}}
{{--                        </li>--}}

                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/inactive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Inactive Product's</a>
                        </li>
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/assign-real-stock"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Add Product In Real Stock</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/low-stock-products"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Low Stock  Product's</a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/waiting-stock-list"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Waiting for  Stock  Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/buy-price-added-products"><i class="fa fa-angle-double-right" aria-hidden="true"></i>   Price added but not in real Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/damage-list">--}}
{{--                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>   Damage Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/clean-history">--}}
{{--                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>  Product's History</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/big-buy-price-products"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Big Stock Products</a>--}}
{{--                        </li>--}}
                    </ul>
                </li>
                <li > <a href="#" data-toggle="collapse" data-target="#drop13" class="drop" >Coupon Discount <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop13" class="collapse">
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/coupon-lists"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Coupon List</a>
                        </li>
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/used-coupon') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Order Used Coupon</a>--}}
{{--                        </li>--}}
                        <li>
                            <a class="nav-link" href="{{ url('ad/new-coupon') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add New Coupon</a>
                        </li>

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/assign-marketer') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Marketer</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/affiliate/customer') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Assign Marketer Users </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/affiliate/users') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Affiliate Customer List </a>--}}
{{--                        </li>--}}

                    </ul>
                </li>
{{--                <li>--}}
{{--                    <a href="{{ url('ad/request-list') }}"> Product Request</a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="#" data-toggle="collapse" data-target="#drop56" class="drop"> Water Sales <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}
{{--                    <ul id="drop56" class="collapse">--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/water_customer/lists"><i class="fa fa-angle-right" aria-hidden="true"></i>  Customers List</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/inactive_customers"><i class="fa fa-angle-right" aria-hidden="true"></i> Water Customers Last Order</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/all-inactive-customers"><i class="fa fa-angle-right" aria-hidden="true"></i> All  Customers Last Order History</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/disable-water-customers"><i class="fa fa-angle-right" aria-hidden="true"></i>  Disable Water Customers  </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}



{{--                <li>--}}
{{--                    <a href="#" data-toggle="collapse" data-target="#drop35" class="drop"> Prescriptions <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}
{{--                    <ul id="drop35" class="collapse">--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/prescriptions"><i class="fa fa-angle-right" aria-hidden="true"></i>  Prescriptions List</a>--}}
{{--                        </li>--}}

{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li > <a href="#" data-toggle="collapse" data-target="#drop9" class="drop" >Office Menu <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}

{{--                    <ul id="drop9" class="collapse">--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/attendance"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Take  Attendance</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/expense"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Expense List</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/add-expense') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add New Expense</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/expense-category') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Expense Category</a>--}}
{{--                        </li>--}}

{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/assets') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Company Assets</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/affiliate-payment-form') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Affiliate Payment</a>--}}
{{--                            </li>--}}

{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/invest') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Company Investment</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/stock-money') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Manage Stock Money</a>--}}
{{--                            </li>--}}

{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/other-income') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Other Income</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/incomes') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Other income List</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a class="nav-link" href="{{ url('ad/trash') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Office Trash List</a>--}}
{{--                            </li>--}}

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/my-delivery') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Find Delivery History</a>--}}
{{--                        </li>--}}

{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="{{ url('ad/refered-Customers') }}"> Referred Customers--}}

{{--                    </a>--}}
{{--                </li>--}}
{{--                <li > <a href="#" data-toggle="collapse" data-target="#drop67" class="drop" > Foods <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}

{{--                    <ul id="drop67" class="collapse">--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/foods"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Add New Food</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/food-list"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Food List</a>--}}
{{--                        </li>--}}

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/restaurants"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Restaurant</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('/ad') }}/restaurants/lists"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Restaurant Lists</a>--}}
{{--                        </li>--}}

{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="{{ url('ad/vendor-request') }}"> Vendor Request--}}
{{--                        @if(isset($vendor_request_count) && $vendor_request_count>0)--}}
{{--                            <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;">{{$vendor_request_count}}</span>--}}
{{--                        @endif--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="{{ url('ad/due-customers') }}"> Due Customers--}}

{{--                    </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="#" data-toggle="collapse" data-target="#drop39" class="drop"> Customer Deposit <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}
{{--                    <ul id="drop39" class="collapse">--}}
{{--                        <li>--}}
{{--                            <a href="{{ url('ad/customer-deposit') }}">Add Customer Deposit</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="{{ url('ad/deposit-request-list') }}">Deposit Request List</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="{{ url('ad/remaining-deposit-amount') }}">Remaining Deposit Amount</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}


{{--                <li > <a href="#" data-toggle="collapse" data-target="#drop33" class="drop" > Medicines <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}

{{--                    <ul id="drop33" class="collapse">--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/add-medicine') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Medicine</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/medicines"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Medicine Lists</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

                <li> <a href="#" data-toggle="collapse" data-target="#drop244" class="drop"> Customers<i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop244" class="collapse">

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/salary-list"><i class="fa fa-angle-right" aria-hidden="true"></i> Employee List  </a>--}}
{{--                        </li>--}}

                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/customers"><i class="fa fa-angle-right" aria-hidden="true"></i> Customer List</a>
                        </li>
                    </ul>
                </li>
                 <li> <a href="#" data-toggle="collapse" data-target="#drop2w4" class="drop"> Reports<i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop2w4" class="collapse">
 
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/daily"><i class="fa fa-angle-right" aria-hidden="true"></i> Daily Report</a>
                        </li>
                         <li>
                            <a class="nav-link" href="{{ url('ad/') }}/monthly"><i class="fa fa-angle-right" aria-hidden="true"></i>Monthly Report</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/cancel-order"><i class="fa fa-angle-right" aria-hidden="true"></i>Cancel Order Report</a>
                        </li>

                    </ul>
                </li>
                <li> <a href="#" data-toggle="collapse" data-target="#drop24" class="drop"> Users<i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop24" class="collapse">

                        {{--                        <li>--}}
                        {{--                            <a class="nav-link" href="{{ url('ad/') }}/salary-list"><i class="fa fa-angle-right" aria-hidden="true"></i> Employee List  </a>--}}
                        {{--                        </li>--}}
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/new-user"><i class="fa fa-angle-right" aria-hidden="true"></i> Add  User</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/users"><i class="fa fa-angle-right" aria-hidden="true"></i>   Users List</a>
                        </li>

                    </ul>
                </li>
                <li> <a href="#" data-toggle="collapse" data-target="#drop211" class="drop"> Advertisement <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop211" class="collapse">
                        {{--                        <li><a  href="{{ url('ad/new-delivery-boy') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Delivery Boys</a></li>--}}

                        {{--                        <li><a  href="{{ url('ad/popup') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Offer Banner</a></li>--}}
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/banner-add"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home Advertisement Add</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/banner"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home Advertisement List</a>
                        </li>


                        {{--                        <li> <a href="{{ url('ad/terms-condition') }}"> Terms & Condition</a>--}}
                        {{--                        </li>--}}

                    </ul>
                </li>
                <li> <a href="#" data-toggle="collapse" data-target="#drop242" class="drop"> Categories <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop242" class="collapse">
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/category"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add     Category</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/category-lists"><i class="fa fa-angle-double-right" aria-hidden="true"></i>   Category Lists</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/sub-category"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Sub Category</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/sub-category-lists"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sub Category Lists</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/child-category"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Child Category</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/child-cat-list"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Child Category Lists</a>
                        </li>


                    </ul>
                </li>
                <li> <a href="#" data-toggle="collapse" data-target="#drop2" class="drop"> Settings <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop2" class="collapse">
{{--                        <li><a  href="{{ url('ad/new-delivery-boy') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Delivery Boys</a></li>--}}

{{--                        <li><a  href="{{ url('ad/popup') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Offer Banner</a></li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/banner-add"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home Banner Add</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/banner"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home Banner List</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/category"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Category</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('ad/') }}/category-lists"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Category Lists</a>--}}
{{--                        </li>--}}


                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/brand"><i class="fa fa-angle-right" aria-hidden="true"></i> Add  brand</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/brand-lists"><i class="fa fa-angle-right" aria-hidden="true"></i> Brand  Lists</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/new_location"><i class="fa fa-angle-right" aria-hidden="true"></i> Add  Location</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('ad/') }}/locations"><i class="fa fa-angle-right" aria-hidden="true"></i> Location List</a>
                        </li>
{{--                        <li> <a href="{{ url('ad/terms-condition') }}"> Terms & Condition</a>--}}
{{--                        </li>--}}
                        <li>
                            <a href="{{ url('ad/add-unit') }}"> Add Unit</a>
                        </li>
                    </ul>
                </li>

                <li><a  href="{{ url('/change-password') }}">
                        Change Password
                    </a></li>
                <li href="#" ><a  href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a></li>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>


                <li>&nbsp;</li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
            </ul>


    </div>
</div>
</div>