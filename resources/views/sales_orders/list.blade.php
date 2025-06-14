@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success" id="flash-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" id="flash-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Sales Order List</h4>
            <a href="{{ route('sales_orders.create') }}" class="btn btn-primary">+ Add Sales</a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order Number</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($sales as $index => $sale)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sale->order_number  }}</td>
                                    <td>{{ $sale->total }}</td>
                                    <td>
                                        <a href="{{ route('sales_orders.show', $sale->id) }}" class="btn btn-sm btn-success" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('sales_orders.delete', $sale->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
