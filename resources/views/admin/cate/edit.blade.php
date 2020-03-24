<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    @include('admin.public.style')
    @include('admin.public.script')
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]--></head>

    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>昵称</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="username"  value="{{$user->user_name}}"required="" lay-verify="nikename" autocomplete="off" class="layui-input"></div>
                            <input type="hidden" name="user_id" value="{{$user->user_id}}">
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>将会成为您唯一的登入名</div></div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_email" value="{{$user->email}}" name="email" required="" lay-verify="email" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>角色</label>
                        <div class="layui-input-block">
                            @foreach($role as $v)
                                @if(in_array($v['id'],$role_id))
                            <input type="checkbox" name="role_id[]" lay-skin="primary" value="{{$v['id']}}" title="{{$v['role_name']}}" checked="">
                                @else
                                    <input type="checkbox" name="role_id[]" lay-skin="primary" value="{{$v['id']}}" title="{{$v['role_name']}}" >
                                    @endif
{{--                            <input type="checkbox" name="like1[read]" lay-skin="primary" title="编辑人员">--}}
{{--                            <input type="checkbox" name="like1[write]" lay-skin="primary" title="宣传人员" checked="">--}}
                                @endforeach
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button></div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    }
                });
                var user_id = $('input[ name="user_id"]').val();
                //监听提交
                form.on('submit(edit)',
                function(data) {
                    $.ajax({
                        type:'PUT',
                        url:'/admin/user/'+user_id,
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

                })
                    //发异步，把数据提交给php


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
