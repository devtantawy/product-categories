@extends('categories.layout')
     
@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h2>Categories List</h2>
        <div class="d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('dashboard') }}"> <i></i>Back To Dashboard</a>
        </div>
    </div>
  <div class="card-body">
          
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
  
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('categories.create') }}"> <i class="fa fa-plus"></i> Create New Category</a>
        </div>
  
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Parent Category</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>
  
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $category->name }}</td>
                    <td> {{$category->is_active == 1 ? 'Active' : 'Not Active'}} </td>
                    <td>
                        {{ $category?->parent?->name }}
                    </td>

                    <td>
                        <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
             
                            <a class="btn btn-info btn-sm" href="{{ route('categories.show',$category->id) }}"><i class="fa-solid fa-list"></i> Show</a>
              
                            <a class="btn btn-primary btn-sm" href="{{ route('categories.edit',$category->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
             
                            @csrf
                            @method('DELETE')
                
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">There are no data.</td>
                </tr>
            @endforelse
            </tbody>
  
        </table>
          
  </div>
</div>      
@endsection