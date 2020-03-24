<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
@include('admin.public.style')
@include('admin.public.script')
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
    <body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="role_name" required="" lay-verify="required"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                        @foreach($permission as $v)
                        <tr>
                            @if($v['pid'] == 0)
                            <td>
                                <input name="id[]" lay-skin="primary" type="checkbox" value="{{$v['id']}}" title="{{$v['per_name']}}" lay-filter="father">
                            </td>
                            @else
                                @continue
                            @endif

                            <td>
                                <div class="layui-input-block">
                                    @foreach($permission as $i)
                                        @if($i['pid'] == $v['id'] )
                                    <input name="id[]" lay-skin="primary" type="checkbox" value="{{$i['id']}}" title="{{$i['per_name']}}">
                                        @else
                                            @continue
                                        @endif
                                    @endforeach
                                </div>
                            </td>

                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn" lay-submit="" lay-filter="add">添加</button>
                </div>
            </form>
        </div>
    </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                //监听提交
                form.on('submit(add)', function(data){

                    //发异步，把数据提交给php
                    $.ajax({
                        type:'POST',
                        url:'/admin/role',
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data.field,
                        success:function(data){
                            // 弹层提示添加成功，并刷新父页面
                            // console.log(data);
                            if(data.status == 1){
                                layer.alert(data.message,{icon:6},function(){
                                    parent.location.reload(true);
                                });
                            }else{
                                layer.alert(data.message,{icon:5});
                            }
                        },
                        error:function(){
                            //错误信息
                        }

                    });
                    return false;
                });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>
