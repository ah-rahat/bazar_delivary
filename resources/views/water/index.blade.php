@extends('layouts.app')
@section('content')
      @if(Auth::user()->role === 'admin')
    @include('layouts.admin-sidebar')
    @else
    @include('layouts.other-sidebar')  
    @endif
    <div class="content-area">
        <div class="container-fluid mt30">
        <div class="row justify-content-center">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Water Sales Tracking </div>
                        <div class="panel-body">
                        <p>Customer Name: {{$user->name}}</p>
                          <p>Customer Phone: {{$user->phone}}</p>
  <p>Customer Address: {{$user->address}}</p>
  <p>Customer Phone: {{$user->phone}}</p>
  <p>Total Filter on Customer: {{$filters}}</p>


  <table>
      <tr>
          <td style="color: orange;">Jar In Customer: {{$total_jar_out}}</td>
          <td style="color:   green;">Jar Collected: {{$total_jar_in}}</td>

      </tr>
      <tr>
          <td style="color: red;">Remaining Jar: </td>
          <td style="color: red;">{{$total_jar_out-$total_jar_in}}</td>

      </tr>
    <tr>
  <td>Sell Price:</td>
  <td>Machine:</td>
  
  </tr>
  <tr>
  
  <td><input type="text" class="form-control jarprice"    value="{{$user->price}}" /></td>
  <td><input type="text" class="form-control tota_dis_jar"   value="{{$user->jar}}" /></td>
  </tr>

  </table>
  <br />
  
                            <div class="table-responsive">
                            <table  class="table table-striped " style="font-size: 14px;">
                                 <thead>
                                 <tr>
                                 <th  width="120">Date</th>
                                  <th width="120">Sell Water</th>
                                   <th width="120">Collect Jar</th>
                                     <th >Comments</th>
                                 </tr>
                                 </thead>
                                <tbody>
                                <input type="hidden" class="cus_id" value="{{$user->id}}" />
                                <tr>
                                 <td>
                                1 - {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="1" value="{{$waters->d_1_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="1" value="{{$waters->d_1_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                       <textarea class="form-control" data-date="1" rows="1" placeholder="Comments">{{$waters->c1}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               2 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="2"  value="{{$waters->d_2_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="2" value="{{$waters->d_2_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="2" rows="1" placeholder="Comments">{{$waters->c2}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               3 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="3"  value="{{$waters->d_3_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="3"  value="{{$waters->d_3_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="3" rows="1" placeholder="Comments">{{$waters->c3}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               4 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="4"  value="{{$waters->d_4_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="4"  value="{{$waters->d_4_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="4" rows="1" placeholder="Comments">{{$waters->c4}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               5 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="5"   value="{{$waters->d_5_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="5" value="{{$waters->d_5_in}}"  class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="5" rows="1" placeholder="Comments">{{$waters->c5}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               6 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="6"  value="{{$waters->d_6_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="6"  value="{{$waters->d_6_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="6" rows="1" placeholder="Comments">{{$waters->c6}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               7 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="7"  value="{{$waters->d_7_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="7"  value="{{$waters->d_7_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="7" rows="1" placeholder="Comments">{{$waters->c7}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               8 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="8"  value="{{$waters->d_8_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="8"  value="{{$waters->d_8_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="8" rows="1" placeholder="Comments">{{$waters->c8}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               9 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="9"  value="{{$waters->d_9_sell}}"  class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="9"  value="{{$waters->d_9_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="9" rows="1" placeholder="Comments">{{$waters->c9}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               10 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="10"  value="{{$waters->d_10_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="10"  value="{{$waters->d_10_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="10" rows="1" placeholder="Comments">{{$waters->c10}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               11 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="11"  value="{{$waters->d_11_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="11" value="{{$waters->d_11_in}}"  class="form-control get_bottle" />
                                </td>
                                    <td>
                                        <textarea class="form-control" data-date="11" rows="1" placeholder="Comments">{{$waters->c11}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               12 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="12"  value="{{$waters->d_12_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="12"  value="{{$waters->d_12_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="12" rows="1" placeholder="Comments">{{$waters->c12}}</textarea>

                                    </td>
                                </tr>
                                <tr>
                                 <td>
                               13 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="13"  value="{{$waters->d_13_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="13"  value="{{$waters->d_13_in}}" class="form-control get_bottle" />
                                </td>
                                    <td>

                                                <textarea class="form-control" data-date="13" rows="1" placeholder="Comments">{{$waters->c13}}</textarea>

                                    </td>
                                </tr>
                                
                                 <tr>
                                 <td>
                               14 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="14"  value="{{$waters->d_14_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="14"  value="{{$waters->d_14_in}}" class="form-control get_bottle" />
                                </td>
                                     <td>

                                                 <textarea class="form-control" data-date="14" rows="1" placeholder="Comments">{{$waters->c14}}</textarea>

                                     </td>
                                </tr>
                                
                                
                                  <tr>
                                 <td>
                               15 {{date('F')}} 
                                </td>
                                <td>
                                <input type="text" data-date="15"  value="{{$waters->d_15_sell}}" class="form-control sell_water" />
                                </td>
                                 <td>
                                <input type="text" data-date="15"  value="{{$waters->d_15_in}}" class="form-control get_bottle" />
                                </td>
                                      <td>

                                                  <textarea class="form-control" data-date="15" rows="1" placeholder="Comments">{{$waters->c15}}</textarea>

                                      </td>
                                </tr>
                                <tr>
<td>
16 {{date('F')}} 
</td>
<td>
<input type="text" data-date="16"  value="{{$waters->d_16_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="16"  value="{{$waters->d_16_in}}" class="form-control get_bottle" />
</td>
                                    <td>

                                                <textarea class="form-control" data-date="16" rows="1" placeholder="Comments">{{$waters->c16}}</textarea>

                                    </td>
</tr><!--end-->
<tr>
<td>
17 {{date('F')}} 
</td>
<td>
<input type="text" data-date="17"  value="{{$waters->d_17_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="17"  value="{{$waters->d_17_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="17" rows="1" placeholder="Comments">{{$waters->c17}}</textarea>

    </td>
</tr><!--end-->

<tr>
<td>
18 {{date('F')}} 
</td>
<td>
<input type="text" data-date="18"  value="{{$waters->d_18_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="18"  value="{{$waters->d_18_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="18" rows="1" placeholder="Comments">{{$waters->c18}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
19 {{date('F')}} 
</td>
<td>
<input type="text" data-date="19"  value="{{$waters->d_19_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="19"  value="{{$waters->d_19_in}}" class="form-control get_bottle" />
</td> <td>

                <textarea class="form-control" data-date="19" rows="1" placeholder="Comments">{{$waters->c19}}</textarea>

    </td>

</tr><!--end-->
<tr>
<td>
20 {{date('F')}} 
</td>
<td>
<input type="text" data-date="20"  value="{{$waters->d_20_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="20"  value="{{$waters->d_20_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="20" rows="1" placeholder="Comments">{{$waters->c20}}</textarea>

    </td>
</tr><!--end--><tr>
<td>
21 {{date('F')}} 
</td>
<td>
<input type="text" data-date="21"  value="{{$waters->d_21_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="21"  value="{{$waters->d_21_in}}" class="form-control get_bottle" />
</td>
                                    <td>

                                                <textarea class="form-control" data-date="21" rows="1" placeholder="Comments">{{$waters->c21}}</textarea>

                                    </td>
</tr><!--end--><tr>
<td>
22 {{date('F')}} 
</td>
<td>
<input type="text" data-date="22"  value="{{$waters->d_22_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="22"  value="{{$waters->d_22_in}}" class="form-control get_bottle" />
</td>
                                    <td>

                                                <textarea class="form-control" data-date="22" rows="1" placeholder="Comments">{{$waters->c22}}</textarea>

                                    </td>
</tr><!--end-->
<tr>
<td>
23 {{date('F')}} 
</td>
<td>
<input type="text" data-date="23"  value="{{$waters->d_23_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="23"  value="{{$waters->d_23_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="23" rows="1" placeholder="Comments">{{$waters->c23}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
24 {{date('F')}} 
</td>
<td>
<input type="text" data-date="24"  value="{{$waters->d_24_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="24"  value="{{$waters->d_24_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="24" rows="1" placeholder="Comments">{{$waters->c24}}</textarea>

    </td>
</tr><!--end--><tr>
<td>
25 {{date('F')}} 
</td>
<td>
<input type="text" data-date="25"  value="{{$waters->d_25_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="25"  value="{{$waters->d_25_in}}" class="form-control get_bottle" />
</td>
                                    <td>

                                                <textarea class="form-control" data-date="25" rows="1" placeholder="Comments">{{$waters->c25}}</textarea>

                                    </td>
</tr><!--end-->
<tr>
<td>
26 {{date('F')}} 
</td>
<td>
<input type="text" data-date="26"  value="{{$waters->d_26_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="26"  value="{{$waters->d_26_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="26" rows="1" placeholder="Comments">{{$waters->c26}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
27 {{date('F')}} 
</td>
<td>
<input type="text" data-date="27"  value="{{$waters->d_27_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="27"  value="{{$waters->d_27_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="27" rows="1" placeholder="Comments">{{$waters->c27}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
28 {{date('F')}} 
</td>
<td>
<input type="text" data-date="28"  value="{{$waters->d_28_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="28"  value="{{$waters->d_28_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="28" rows="1" placeholder="Comments">{{$waters->c28}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
29 {{date('F')}} 
</td>
<td>
<input type="text" data-date="29"  value="{{$waters->d_29_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="29"  value="{{$waters->d_29_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="29" rows="1" placeholder="Comments">{{$waters->c29}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
30 {{date('F')}} 
</td>
<td>
<input type="text" data-date="30"  value="{{$waters->d_30_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="30"  value="{{$waters->d_30_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="30" rows="1" placeholder="Comments">{{$waters->c30}}</textarea>

    </td>
</tr><!--end-->
<tr>
<td>
31 {{date('F')}} 
</td>
<td>
<input type="text" data-date="31"  value="{{$waters->d_31_sell}}" class="form-control sell_water" />
</td>
<td>
<input type="text" data-date="31"  value="{{$waters->d_31_in}}" class="form-control get_bottle" />
</td>
    <td>

                <textarea class="form-control" data-date="31" rows="1" placeholder="Comments">{{$waters->c31}}</textarea>

    </td>
</tr><!--end-->


















                                
 
       
        
                                 
                                </tbody>
                            </table>
                            </div>
 
                    </div>
                     
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

    
 @section('footerjs')
 	<script>
 		    

                
                      
  jQuery.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
 
          jQuery('.tota_dis_jar').change(function() {
             var  customer_id=jQuery(".cus_id").val(); 
             var tota_dis_jar= jQuery(this).val();
              
          jQuery.ajax({
               type:'GET',
                url:'dispancer/'+customer_id+'/'+tota_dis_jar,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
                 Command: toastr["info"]("Total given Machine Updated");
                    
               }
            });
  
});

   
          jQuery('.jarprice').change(function() {
             var  customer_id=jQuery(".cus_id").val();
           
             var jarprice= jQuery(this).val();
              
          jQuery.ajax({
               type:'GET',
                url:'collect-price/'+customer_id+'/'+jarprice,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
                 Command: toastr["info"]("Sell Price Updated");
                    
               }
            });
  
});

  jQuery('textarea').change(function() {
      var  customer_id=jQuery(".cus_id").val();
      var  date=jQuery(this).data('date');
      var comment= jQuery(this).val();

      jQuery.ajax({
          type:'GET',
          url:'comment/'+customer_id+'/'+date+'/'+comment,
          dataType: "json",
          data:'_token = <?php echo csrf_token() ?>',
          success:function(res) {
              console.log(res);
              Command: toastr["info"]("comment added");

          }
      });

  });

  
          jQuery('.get_bottle').change(function() {
             var  customer_id=jQuery(".cus_id").val();
          
              var  date=jQuery(this).data('date');
               
             var get_bottle= jQuery(this).val();
              
          jQuery.ajax({
               type:'GET',
                url:'collect/'+customer_id+'/'+date+'/'+get_bottle,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
                 Command: toastr["info"]("Jar Collected");
                    
               }
            });
  
});

      
        jQuery('.sell_water').change(function() {
             var  customer_id=jQuery(".cus_id").val();
          
              var  date=jQuery(this).data('date');
               
             var sell_amount= jQuery(this).val();
              
          jQuery.ajax({
               type:'GET',
                url:'sell/'+customer_id+'/'+date+'/'+sell_amount,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
                 Command: toastr["success"]("Water Sell Added");
                    
               }
            });
  
});
       
       
 toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}      
       
       
		</script>   
    
@endsection

