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
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">prescriptions List</div>
                        <div class="panel-body">
                       
                            <div>
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>#ID</td> 
                                        <td>PHONE</td>
                                       
                                        <td>USER NAME</td>
                                         <td>FILE</td> 
                                         <td>STATUS</td>
                                          <td width="100px"></td>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($prescriptions   as $prescription)
  
                                        <tr>
                                         <td>#{{$prescription->id}}</td>
                                          <td>{{$prescription->phone}}</td>
                                           
                                            <td>
                                             @foreach ($users  as $user)
                                             @if($prescription->phone== $user->phone)
                                             {{ $user->name}}
                                             @endif
                                           @endforeach 
                                            </td>
                                            <td>
                                              
                                            <img class="img-thumbnail" data-toggle="modal" data-target="#{{$prescription->id}}" src="https://gopalganjbazar.com/web/uploads/prescription/{{$prescription->file}}"  style="height: 50px;"  />
                                            <div id="{{$prescription->id}}" class="modal fade" role="dialog">
                                                  
                                                  <div class="modal-dialog" style="width: auto !important;"> 
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Prescription ID: {{$prescription->id}}</h4>
                                                      </div>
                                                      <div class="modal-body text-center">
                                                         <img style="max-width:100%;" src="https://gopalganjbazar.com/web/uploads/prescription/{{$prescription->file}}" />
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      </div>
                                                    </div> 
                                                  </div>
                                                </div>
                                            
                                            
                                            </td> 
                                             <td>
                                             @if($prescription->status==1)
                                             <span style="color: #388e3c;background: #c8e6c9;padding: 3px 6px;border-radius: 2px;
border: 1px solid #81c784;">Complete</span>
                                             @else
                                              <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;">Pending</span>
                                             @endif
                                             </td>
                                             <td>
                                              @if($prescription->status==0)
                                             <a href="prescription-checked/{{$prescription->id}}" class="btn btn-success">Done</a>
                                             @endif
                                             </td>
                                             
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        <div class="text-right">
                         
                        {{  $prescriptions  }}
                        
                       </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @section('footerjs')
    <script>
   
  //  $('.img').click(function(){ 
        //jQuery(this).animate({width: "100%",height: "100%"}, 500) 
  // });
   
    </script>
    @endsection
@endsection
