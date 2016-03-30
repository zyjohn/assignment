@extends('master')

@section('title', 'Product List')

@section('content')
    <div class="weui_cells weui_cells_access">
        @foreach($products as $product)
            <a class="weui_cell" href="/product/{{$product->id}}">
                <div class="weui_cell_hd"><img class="product_preview" height=100 width=100 src="{{$product->preview}}"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <div style="margin-bottom: 10px;">
                        <span class="product_title">{{$product->name}}</span>
                        <span class="product_price" style="float: right;">$ {{$product->price}}</span>
                    </div>

                    <p class="product_summary">{{$product->summary}}</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
        @endforeach
    </div>
@endsection

@section('my-js')

@endsection
