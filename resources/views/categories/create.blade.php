@extends('categories.layout')
  
@section('content')
<div class="card mt-5">
  <h2 class="card-header">Add New Category</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('categories.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
  
        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Name:</strong></label>
            <input 
                type="text" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                id="inputName" 
                placeholder="Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active"  value=1
                    class="form-control @error('is_active') is-invalid @enderror" 
                    id="inputIsActive" 
                >
                <label class="form-check-label" for="is_active">
                  Active
                </label>
              </div>
            @error('is_active')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="parent_category">Parent Category</label>
            <select name="parent_category" id="parent_category">
                <option value="">Select</option>
                @foreach($categories as $category)
                    <option
                        @if ($category->parent?->id === (int) old('parent_category'))
                            selected
                        @endif
                        value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('parent_category')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
    </form>
  
  </div>
</div>
@endsection