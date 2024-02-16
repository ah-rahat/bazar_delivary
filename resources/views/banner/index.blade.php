@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
	<div class="container-fluid mt30">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="panel panel-default simple-panel">
					<div class="panel-heading">
						Office Expense List
					</div>
					<div class="panel-body">
                      @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
						<table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
							<thead>
								<tr>
									<th>
										SN
									</th>
									<th>
										Image
									</th>
								  	<th>
										Type
									</th>
									<th>
										Link
									</th>
									<th class="text-center" width="35px">
									</th>
							
								</tr>
							</thead>
							<tbody>
								@foreach ($banners as $index => $banner)
								<tr>
									<td>
										{{$index+1}}
									</td>
									<td>
									<img style="height: 100px;" src="{{URL::to('/uploads/banner_images')}}/{{$banner->banner_image}}" />
									</td>
									<td>
									 
											@if($banner->type==1)
                                            Slider
                                            @else
                                            Small Banner
                                            @endif
										 
									</td>
									<td>{{$banner->link}}</td>
                                    <td>
                                    <a href="banner/{{$banner->id}}" class="btn btn-warning"><i class="fa fa-trash"></i></a></td>
							  
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection