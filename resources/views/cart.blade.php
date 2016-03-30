@extends('master')

@section('title', 'Shopping Cart')

@section('content')
    <div class="weui_cells weui_cells_access">
        @foreach($cart_items as $cart_item)
            <div class="weui_cell_hd"><img class="product_preview" height=50 width=50 src="{{$cart_item->product->preview}}"></div>
            <div class="weui_cell_bd weui_cell_primary">
                <div style="margin-bottom: 10px;">
                    <span class="product_title">{{$cart_item->product->name}}</span>
                    <span class="product_price">${{$cart_item->product->price}}</span>
                    <span style="float: right;">
                        <span id="less{{$cart_item->id}}" onclick='option_less("{{$cart_item->id}}")' class="ml-5" style="text-decoration:none"><i class="glyphicon glyphicon-minus" style="cursor: pointer; cursor: hand;"></i></span>
                        <span style="width: 60px">{{$cart_item->quantity}}</span>
                        <span id="add{{$cart_item->option->id}}" onclick='option_plus("{{$cart_item->option->id}}")' class="ml-5" style="text-decoration:none"><i class="glyphicon glyphicon-plus" style="cursor: pointer; cursor: hand;"></i></span>
                    </span>

                </div>

                <p class="product_summary">Color: {{$cart_item->option->color}} / Size: {{$cart_item->option->size}}</p>
            </div>
            <div class="weui_cell_ft"></div>
        @endforeach
    </div>
    <hr>
    <div style="margin-left: 2em">
        <button class="btn btn-lg btn-success" onclick="pay_cart()">Pay</button>
    </div>    
@endsection
    <script type="text/javascript">
        function option_less(id) {
            $.ajax({
                type: "GET",
                url: '/service/cart/less/' + id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data == null) {
                        alert('Server Error');
                        return;
                    }
                    if(data.status != 0) {
                        alert(data.message);
                        return;
                    }

                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    alter('ajax error');
                },
            });

            return false;
        }
        function option_plus(option_id) {
            $.ajax({
                type: 'GET',
                url: '/service/cart/add/' + option_id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data == null) {
                        alert('Server Error');
                        return;
                    }
                    if(data.status != 0) {
                        alert(data.message);
                        return;
                    }

                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    alter('ajax error');
                },
            });

            return false;
        }
        function pay_cart() {
            $.ajax({
                type: 'post',
                url: '/service/cart/pay',
                dataType: 'json',
                success: function(data) {
                    if(data == null) {
                        alert('Server Error');
                        return false;
                    }
                    if(data.status != 0) {
                        alert(data.message);
                        return false;
                    }
                    location.href=('/product/list');
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    return false;
                },
            });

            return false;            
        }
    </script>
@section('my-js')

@endsection
