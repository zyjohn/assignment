@extends('admin.master')

@section('content')
    <div class="pd-20">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
  		<span class="l">
  			<a href="javascript:;" onclick="product_add('Add Product','/admin/product_add')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> Add Product</a>
  		</span>
            <span class="r">Total: <strong>{{count($products)}}</strong> product(s).</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">Name</th>
                    <th width="40">Summary</th>
                    <th width="90">Price</th>
                    <th width="50">Preview</th>
                    <th width="100">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="text-c">
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->summary}}</td>
                        <td>{{$product->price}}</td>
                        <td>@if($product->preview != null)
                                <img src="{{$product->preview}}" alt="" style="width: 50px; height: 50px;">
                            @endif</td>
                        <td class="td-manage">
                            <a title="Edit" href="javascript:;" onclick="product_edit('Edit Product','/admin/product_edit?id={{$product->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a title="Delete" href="javascript:;" id="del{{$product->id}}" onclick='product_delete("{{$product->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
        function product_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        function product_edit(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        function product_delete(id) {
            var element_id = '#del' + id;
            $(element_id).ajaxSubmit({
                type: 'post',
                url: '/admin/service/product/delete',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(data) {
                    if(data == null) {
                        alert('Server Error');
                        return;
                    }
                    if(data.status != 0) {
                        alert(data.message);
                        return;
                    }

                    parent.location.reload();
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
    </script>
@endsection
