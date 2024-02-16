<div class="left-area">
    <!--<div id="navbar" class="navbar-collapse left-area collapse in" aria-expanded="true" style="">-->
    <div class="left-humberger-menu ">
        <div class="sidebar">
            <a class="logo-area text-center" href="{{ url('/shop') }}">
                <img src="https://gopalganjbazar.com/static/img/gopalgonjbazar-logo.69a19e5.png" width="150px"/>
            </a>
            <span>NAVIGATION</span>


            <ul>
                <li><a href="{{ url('shop') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>

                <li>
                    <a href="#" data-toggle="collapse" data-target="#drop10" class="drop"> Orders <i
                                class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>
                    <ul id="drop10" class="collapse">
                        <li>
                            <a class="nav-link" href="{{ url('/shop') }}/shop-order"><i
                                        class="fa fa-angle-right" aria-hidden="true"></i> Create Order</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/shop') }}/today-orders"><i class="fa fa-angle-right"
                                                                                          aria-hidden="true"></i> Today
                                Order's</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('shop/') }}/orders"><i class="fa fa-angle-right"
                                                                                    aria-hidden="true"></i> All Order
                                Lists</a>
                        </li>
{{--                                                    <li>--}}
{{--                                                        <a class="nav-link" href="{{ url('ad/') }}/best-buy-customers"><i class="fa fa-angle-right" aria-hidden="true"></i>  Highest Order Customers</a>--}}
{{--                                                    </li>--}}
                    </ul>
                </li>
                <li><a href="#" data-toggle="collapse" data-target="#drop1" class="drop"> Products <i
                                class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                    <ul id="drop1" class="collapse">
                        <li>
                            <a class="nav-link" href="{{ url('shop/add-product') }}"><i class="fa fa-angle-double-right"
                                                                                        aria-hidden="true"></i> Add
                                Product</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('shop/') }}/products"><i class="fa fa-angle-double-right"
                                                                                      aria-hidden="true"></i> Active
                                Product's</a>
                        </li>

                        <li>
                            <a class="nav-link" href="{{ url('/shop') }}/product/stock"><i
                                        class="fa fa-angle-double-right" aria-hidden="true"></i> Update Stock</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/shop') }}/instock-products"><i
                                        class="fa fa-angle-double-right" aria-hidden="true"></i> In Stock Product's</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/shop') }}/need-to-add-stock-products"><i
                                        class="fa fa-angle-double-right" aria-hidden="true"></i> Not IN Stock Product's</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/shop') }}/inactive-products"><i
                                        class="fa fa-angle-double-right" aria-hidden="true"></i>  INactive Product's</a>
                        </li>

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('shop/') }}/regular-checking-products"><i--}}
{{--                                        class="fa fa-angle-double-right" aria-hidden="true"></i> Regular Checking--}}
{{--                                Product's</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('shop/') }}/regular_products"><i--}}
{{--                                        class="fa fa-angle-double-right" aria-hidden="true"></i> Add Regular Checking--}}
{{--                                Product's</a>--}}
{{--                        </li>--}}


                        {{--                            <li>--}}
                        {{--                                <a class="nav-link" href="{{ url('ad/') }}/inactive"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Inactive Product's</a>--}}
                        {{--                            </li>--}}
                        {{--                            <li>--}}
                        {{--                                <a class="nav-link" href="{{ url('/ad') }}/assign-real-stock"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Add Product In Real Stock</a>--}}
                        {{--                            </li>--}}
                        {{--                            <li>--}}
                        {{--                                <a class="nav-link" href="{{ url('/ad') }}/low-stock-products"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Low Stock  Product's</a>--}}
                        {{--                            </li>--}}

                        {{--                            <li>--}}
                        {{--                                <a class="nav-link" href="{{ url('/ad') }}/waiting-stock-list"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Waiting for  Stock  Product's</a>--}}
                        {{--                            </li>--}}

                    </ul>
                </li>
                <li>
                    <a class="nav-link" href="{{ url('shop/shop/extra-money') }}">Today Extra Money</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ url('shop/shop/shop-expense') }}">Shop Expense   </a>
                </li>
{{--                @if(Auth::user()->id == '1')--}}
                    <li > <a href="#" data-toggle="collapse" data-target="#drop333" class="drop" > Shop <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>

                        <ul id="drop333" class="collapse">
                            <li>
                                <a class="nav-link" href="{{ url('shop/shop-investment') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Manage Shop  Money</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ url('shop/shop/today-orders') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Shop Today Orders</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ url('shop/shop/dayend-sold-products') }}/{{date('d-m-Y')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  Shop Today Sold Products</a>
                            </li>
                        </ul>
                    </li>
{{--                @endif--}}
                {{--                    <li>--}}
                {{--                        <a href="#" data-toggle="collapse" data-target="#drop56" class="drop"> Water Sales <i class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}
                {{--                        <ul id="drop56" class="collapse">--}}
                {{--                            <li>--}}
                {{--                                <a class="nav-link" href="{{ url('ad/') }}/water_customer/lists"><i class="fa fa-angle-right" aria-hidden="true"></i>  Customers List</a>--}}
                {{--                            </li>--}}
                {{--                            <li>--}}
                {{--                                <a class="nav-link" href="{{ url('ad/') }}/inactive_customers"><i class="fa fa-angle-right" aria-hidden="true"></i> Water Customers Last Order</a>--}}
                {{--                            </li>--}}
                {{--                            <li>--}}
                {{--                                <a class="nav-link" href="{{ url('ad/') }}/all-inactive-customers"><i class="fa fa-angle-right" aria-hidden="true"></i> All  Customers Last Order History</a>--}}
                {{--                            </li>--}}
                {{--                            <li>--}}
                {{--                                <a class="nav-link" href="{{ url('ad/') }}/disable-water-customers"><i class="fa fa-angle-right" aria-hidden="true"></i>  Disable Water Customers  </a>--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}


{{--                <li><a href="#" data-toggle="collapse" data-target="#drop9" class="drop">Office Menu <i--}}
{{--                                class="fa fa-angle-down pull-right" aria-hidden="true"></i></a>--}}

{{--                    <ul id="drop9" class="collapse">--}}

{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('shop/') }}/expense"><i class="fa fa-angle-double-right"--}}
{{--                                                                                     aria-hidden="true"></i> Expense--}}
{{--                                List</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="nav-link" href="{{ url('shop/add-expense') }}"><i class="fa fa-angle-double-right"--}}
{{--                                                                                        aria-hidden="true"></i> Add New--}}
{{--                                Expense</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}




                <li><a href="{{ url('/change-password') }}">
                        Change Password
                    </a></li>
                <li href="#"><a href="{{ route('logout') }}"
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