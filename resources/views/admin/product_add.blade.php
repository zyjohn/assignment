@extends('admin.master')

@section('content')
    <form action="" method="post" class="form form-horizontal" id="form-product-add">
        {{ csrf_field() }}

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Name:</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="" placeholder="" name="name" datatype="*" nullmsg="Name can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Summary</label>
            <div class="formControls col-5">
                <input type="text" class="input-text" value="" placeholder="" name="summary"  datatype="*" nullmsg="Summary can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>Price:</label>
            <div class="formControls col-5">
                <input type="number" class="input-text" value="999" placeholder="" name="price"  datatype="*" nullmsg="Price can not empty">
            </div>
            <div class="col-4"> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">Proview:</label>
            <div class="formControls col-5">
                <img id="preview_id" src="/admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">Details:</label>
            <div class="formControls col-8">
                <textarea id="editor_plain" type="text/plain" name="content" style="width:100%; height:400px;"></textarea>
            </div>
        </div>

        <div class="row cl">
            <div class="col-8 col-offset-2">
                <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;">
            </div>
        </div>
    </form>
@endsection

@section('my-js')
    <script type="text/javascript">

        $("#form-product-add").Validform({
            tiptype:2,
            callback:function(form){
                $('#form-product-add').ajaxSubmit({
                    type: 'post',
                    url: '/admin/service/product/add',
                    dataType: 'json',
                    data: {
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

    </script>
@endsection
