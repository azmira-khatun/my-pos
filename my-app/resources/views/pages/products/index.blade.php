@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Product Management 📦</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Add New Product</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name (Code)</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Alert Stock</th>
                    <th width="150px">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $product->product_name }}</strong>
                        <br><small>Code: {{ $product->product_code }}</small>
                    </td>
                    {{-- Assuming you have a Category relationship defined in Product model --}}
                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td>${{ number_format($product->product_price, 2) }}</td>
                    <td>
                        {{ $product->product_quantity }} {{ $product->product_unit }}
                        @if ($product->product_quantity <= $product->product_stock_alert)
                            <span class="badge bg-danger">Low Stock</span>
                        @endif
                    </td>
                    <td>{{ $product->product_stock_alert }}</td>
                    <td>
                        <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('products.show',$product->id) }}">View</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('products.edit',$product->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $products->links() !!}
</div>
@endsection
