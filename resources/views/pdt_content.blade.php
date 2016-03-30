@extends('master')

@section('title', $product->name)

@section('content')

    <div class="page bk_content" style="top: 0;">

        <div class="weui_cells_title">
            <span class="bk_title">{{$product->name}}</span>
            <span class="bk_price" style="float: right">$ {{$product->price}}</span>
        </div>
        <div class="weui_cells">
            <div class="weui_cell">
                <p class="bk_summary">{{$product->summary}}</p>
            </div>
        </div>
        <div class="weui_cells">
            <img height=200 width=200 src={{$product->preview}}>
        </div>

        <div class="weui_cells_title">Details</div>
        <div class="weui_cells">
            <p>{{$product->content}}</p>
        </div>
        <div class="weui_cells_title">Options</div>
        <div>
            <select id="option">
               @foreach($options as $option)
              <option value="{{$option->id}}">Color: {{$option->color}}; Size: {{$option->size}}</option>
              @endforeach
            </select>                   
                
        </div>
      </div>

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="_addCart();">Add to cart</button>
        </div>
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="_toCart()">View cart(<span id="cart_num" class="m3_price">{{$count}}</span>)</button>
        </div>
    </div>

@endsection

@section('my-js')
    <script type="text/javascript">

        function _addCart() {
            var option_id = $('#option').val();
            $.ajax({
                type: "GET",
                url: '/service/cart/add/' + option_id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('server error');
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }
                    if(data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }

                    var num = $('#cart_num').html();
                    if(num == '') num = 0;
                    $('#cart_num').html(Number(num) + 1);

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }

        function _toCart() {
            location.href = '/cart';
        }
    </script>


@endsection
