@extends('categories.layout')
   
@section('content')
<div class="card mt-5">
  <h2 class="card-header">Show Category</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('categories.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name :</strong> <br/>
                {{ $category->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Is Active :</strong> <br/>
                {{$category->is_active == 1 ? 'Active' : 'Not Active'}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Parent Category:</strong><br/>
                {{ $category?->parent?->name }}
            </div>
        </div>
    </div>
  
  </div>
</div>
@endsection