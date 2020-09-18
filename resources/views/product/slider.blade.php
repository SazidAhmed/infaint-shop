@extends('layouts.admin.app')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>
<div class="row justify-content-end">
  @if(Session::has('message'))
  <div class="alert alert-rounded alert-success">
    {{Session::get('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  @endif

  @if ($errors->any())
    @foreach ($errors->all() as $error) 
      <div class="alert alert-rounded alert-danger">
        {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
    @endforeach
  @endif
</div>

<div class="row">
  <!-- Slider -->
  <div class="col-lg-8 col-xlg-8 col-md-12">
    <div class="ribbon-wrapper card">
      <div class="ribbon ribbon-bookmark ribbon-primary"> Slider Images</div>
      <div class="card-body">
          <!-- Create modal -->
          <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">Add New</button>
        <div class="align-self-center">
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>Index</th><th></th>
                <th>Name</th><th></th>
                <th>Image</th><th></th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sliders as $key=> $slider)
              <tr>
                <td>{{$key+1}}</td><td></td>
                <td>{{$slider->name}}</td><td></td>
                <td><img src="storage/slider/{{$slider->image}}"  height="60"></td><td></td>
                <td>
                  <!-- View button -->
                  <a data-toggle="modal" href="#viewmodal{{$slider->id}}"><i class="material-icons text-info ">visibility</i></a>
                  <!-- edit button -->
                  <a data-toggle="modal" href="#editmodal{{$slider->id}}"><i class="material-icons text-success">edit</i></a>
                  <!-- Delete button -->
                  <a data-toggle="modal" href="#deletemodal{{$slider->id}}"><i class="material-icons text-danger">delete</i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

  <!--Actions Slider -->

  @foreach($sliders as $key=> $slider)
  <!-- View Modal -->
  <div id="viewmodal{{$slider->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="ribbon-wrapper">
          <div class="ribbon ribbon-bookmark ribbon-primary">Slider Details</div>
        </div>
        <div class="modal-body">
            <div class="row center">
              <div class="col-lg-12 col-xlg-12 col-md-12">
                <table class="table table-responsive">
                  <tbody>
                    <tr>
                      <td class="text-info">Slider ID</td>
                      <td>{{$slider->id}}</td>
                    </tr>
                    <tr>
                      <td class="text-info">Name</td>
                      <td>{{$slider->name}}</td>
                    </tr>
                    <tr>
                      <td class="text-info">Created On</td>
                      <td>{{$slider->created_at}}</td>
                    </tr>
                    <tr>
                      <td class="text-info">Last Update</td>
                      <td>{{$slider->updated_at}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-rounded btn-primary"
              data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Modal -->
  <div id="editmodal{{$slider->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="floating-labels m-t-40" id="ecatForm" action="{{route('slider.update',[$slider->id])}}"  method="post" enctype="multipart/form-data">@csrf
        {{method_field('PATCH')}}
        <div class="modal-content">
          <div class="ribbon-wrapper">
            <div class="ribbon ribbon-bookmark ribbon-primary">UpdateCategory</div>
          </div>
          <div class="modal-body">
            <div class="form-group has-success m-b-40">
              <input type="text" class="form-control" id="ecatname" name="name" value="{{$slider->name}}"><span class="bar"></span>
              <label for="ecatname">Name</label>
            </div>
            <div class="form-group has-success m-b-40">
              <input type="file" name="image" accept="image/*" id="ecatimage"><span class="bar"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-rounded btn-danger"
                data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-sm btn-rounded btn-success">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
   <!-- Delete Modal -->
  <div id="deletemodal{{$slider->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <form action="{{route('slider.destroy',[$slider->id])}}" method="post">@csrf
      {{method_field('DELETE')}}
        <div class="modal-content">
          <div class="ribbon-wrapper">
            <div class="ribbon ribbon-bookmark ribbon-primary">Slider : {{$slider->name}}</div>
          </div>
          <div class="modal-body">
            <h4 class="text-center">Confirm To Delete</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-rounded btn-danger"
                data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-sm btn-rounded btn-success">Confirm</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endforeach
 
<!--Slider Create Modal -->
<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="floating-labels m-t-40" id="catForm" action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">@csrf
      <div class="modal-content">
        <div class="ribbon-wrapper">
          <div class="ribbon ribbon-bookmark ribbon-primary">New Slider</div>
        </div>
        <div class="modal-body">
          <div class="form-group has-success m-b-40">
            <input type="text" class="form-control" id="catname" name="name"><span class="bar"></span>
            <label for="catname">Name</label>
          </div>
          <div class="form-group has-success m-b-40">
            <input type="file" name="image" accept="image/*" id="catimage"><span class="bar"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-rounded btn-danger"
              data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-sm btn-rounded btn-success">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
