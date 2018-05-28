@extends('admin.layout.master')
@section('title', __('product.admin.edit.title'))
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{__('product.admin.edit.form_title')}}
        <small>{{__('product.admin.edit.product')}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>{{__('admin.dashboard')}}</a></li>
        <li><a href="#">{{__('product.admin.edit.manage_product')}}</a></li>
        <li class="active">{{__('product.admin.edit.edit_product')}}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{__('product.admin.edit.edit')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{route('product.update', ['product' => $product])}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
              <div class="box-body">
                <div class="form-group">
                  <label>{{__('product.admin.edit.name')}}</label>
                  <input type="text" class="form-control" name="name" value="{{$product->name}}">
                </div>
                <div class="form-group">
                  <label>{{__('product.admin.edit.price')}}</label>
                  <input type="number" step="any" class="form-control" name="price" value="{{$product->price}}">
                </div>
                <div class="form-group">
                  <label>{{__('product.admin.edit.quantity')}}</label>
                  <input type="number" class="form-control" name="quantity" value="{{$product->quantity}}">
                </div>
                <div class="form-group">
                  <label>{{__('product.admin.edit.category')}}</label>
                  <select class="form-control" name="category_id">
                    @include('admin.product.editCategory')
                  </select>
                </div>
                <div class="form-group">
                  <label>{{__('product.admin.edit.preview')}}</label>
                  <textarea class="form-control" name="preview" rows="3">{{$product->preview}}</textarea>
                </div>
                <div class="form-group">
                  <label>{{__('product.admin.edit.description')}}</label>
                  <textarea class="form-control" name="description" rows="3">{{$product->description}}</textarea>
                </div>
                <div class="form-group">
                  <label>{{__('product.admin.edit.image')}}</label>
                  @foreach ($product->images as $image)
                    <div id="deleteImage{{ $image->id }}" class="image-edit-product">
                      <span id="delete{{ $image->id }}" data-id="{{ $image->id }}" data-token="{{ csrf_token() }}" class="delete"><i class="fa fa-trash"></i></span>
                      <img id="image{{ $image->id }}" class="image-edit" src="{{ $image->image_url }}" alt="{{$product->name}}">
                    </div>
                  @endforeach
                  <input type="file" multiple name="images[]">  
                </div>               
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submit">{{__('product.admin.edit.submit')}}</button>
                @include('admin.errors.error_validation')
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection