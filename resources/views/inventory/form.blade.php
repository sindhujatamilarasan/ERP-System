@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header text-center">
            <h4 class="mb-0">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}" method="POST">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif
                <div class="form-group mb-3">
                    <label for="sku">Sku</label>
                    <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror"
                           value="{{ old('sku', $product->sku ?? '') }}">
                      @error('sku')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                      @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name ?? '') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                           value="{{ old('quantity', $product->quantity ?? '') }}">
                    @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $product->price ?? '') }}">
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($product) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
