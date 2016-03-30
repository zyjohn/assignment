@extends('admin.master')

@section('content')
    <form action="" method="post" class="form form-horizontal" id="form-product-edit">

    <input type="hidden" name="id" value="{{$product->id}}">

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Name:</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="{{$product->name}}" placeholder="" name="name" datatype="*" nullmsg="Name can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Summary</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="{{$product->summary}}" placeholder="" name="summary"  datatype="*" nullmsg="Summary can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Price:</label>
            <div class="formControls col-5">
                <input type="number" class="input-text" value="{{$product->price}}" placeholder="" name="price"  datatype="*" nullmsg="Price can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">Proview:</label>
            <div class="formControls col-5">
                <img id="preview_id" src="{{$product->preview}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">Details:</label>
            <div class="formControls col-8">
                <textarea id="editor_plain" type="text/plain" name="content" style="width:100%; height:100px;">{{$product->content}}</textarea>
            </div>
        </div>

        <div class="row cl">
            <div class="col-8 col-offset-2">
                <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">Current Options:</label>
            <div class="col-8">
               <table class="table table-border table-bordered table-hover table-bg table-sort formControls col-8" style="width: 80%;">
                    <thead>
                    <tr class="text-c">
                        <th width="200">Color</th>
                        <th width="200">Size</th>
                        <th width="200">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($options as $option)
                        <tr class="text-c">
                            <td>{{$option->color}}</td>
                            <td>{{$option->size}}</td>
                            <td class="td-manage">
                                <a title="Delete" href="javascript:;" id="del{{$option->id}}" onclick='option_delete("{{$option->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </form>
  
    <form action="" method="post" class="form form-horizontal" id="form-option-edit">

        <input type="hidden" name="product_id" value="{{$product->id}}">

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Color:</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="" placeholder="" name="color"  datatype="*" nullmsg="Color can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Size:</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="" placeholder="" name="size"  datatype="*" nullmsg="Size can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <div class="col-8 col-offset-2">
                <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;Add Option&nbsp;&nbsp;">
            </div>
        </div>
    </form>

@endsection

@section('my-js')
    <script type="text/javascript">

        $("#form-product-edit").Validform({
            tiptype:2,
            callback:function(form){
                $('#form-product-edit').ajaxSubmit({
                    type: 'post',
                    url: '/admin/service/product/replace',
                    dataType: 'json',
                    data: {
                        id: $('input[name=id]').val(),
                        name: $('input[name=name]').val(),
                        summary: $('input[name=summary]').val(),
                        price: $('input[name=price]').val(),
                        preview: ($('#preview_id').attr('src')!='/admin/images/icon-add.png'?$('#preview_id').attr('src'):''),
                        content: $('input[name=content]').val()
                    },
                    success: function(data) {
                        if(data == null) {
                            layer.msg('Server Error', {icon:2, time:2000});
                            return;
                        }
                        if(data.status != 0) {
                            layer.msg(data.message, {icon:2, time:2000});
                            return;
                        }

                        layer.msg(data.message, {icon:1, time:2000});
                        parent.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    },
                });

                return false;
            }
        });
        $("#form-option-edit").Validform({
            tiptype:2,
            callback:function(form){
                $('#form-option-edit').ajaxSubmit({
                    type: 'post',
                    url: '/admin/service/option/add',
                    dataType: 'json',
                    data: {
                        product_id: $('input[name=product_id]').val(),
                        color: $('input[name=color]').val(),
                        size: $('input[name=size]').val()
                    },
                    success: function(data) {
                        if(data == null) {
                            layer.msg('Server Error', {icon:2, time:2000});
                            return;
                        }
                        if(data.status != 0) {
                            layer.msg(data.message, {icon:2, time:2000});
                            return;
                        }

                        layer.msg(data.message, {icon:1, time:2000});
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                });

                return false;
            }
        });
        function option_delete(id) {
            var element_id = '#del' + id;
            $(element_id).ajaxSubmit({
                type: 'post',
                url: '/admin/service/option/delete',
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

    </script>
@endsection
