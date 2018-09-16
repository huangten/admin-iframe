@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
        </div>

        <div class="box-body">
            <form action="{{route('admin.permission.update', $permission)}}" class="form-horizontal validate" method="post">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="form-group">
                    <label class="control-label col-md-2">使用区域</label>
                    <div class="col-md-8 checkbox">
                        <label><input type="radio" name="guard_name" value="admin" {{$permission->guard_name=='admin'?'checked':''}}> 后台</label>
                        <p class="help-block">目前只支持后台</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label col-md-2">Key*</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" value="{{$permission->name}}" id="inputName" data-rule-required="true" data-rule-remote="{{route('api.web.unique', ['table'=>'permissions', 'unique'=>'name', 'ignore'=>$permission->id])}}">
                        <p class="help-block">权限的路由 <code>name</code>, 请询问 <code>网站开发者</code></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDisplayName" class="control-label col-md-2">名称*</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="display_name" value="{{$permission->display_name}}"  id="inputDisplayName" data-rule-required="true">
                        <p class="help-block">权限的中文名称, 不能重复</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="selectPid" class="control-label col-md-2">上级</label>
                    <div class="col-md-8">
                        <select name="pid" class="form-control" id="selectPid" data-ajax-url="{{route('api.web.permission', ['pid' => 0])}}">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <button type="submit" class="btn btn-primary">提交</button>
                        <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            var item = JSON.parse('{!! json_encode($permission->parent) !!}');
            $('#selectPid').select2({
                placeholder: '请选择',
                allowClear: true,
                data: [item],
                dataType: 'json',
                ajax: {
                    delay: 500,
                    data: function (params) {
                        return {
                            name: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data,
                            pagination: {
                                more: data.meta?data.meta.current_page < data.meta.last_page:false
                            }
                        };
                    },
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function (repo) {
                    return repo.display_name?repo.display_name:''
                },
                templateSelection: function (repo) {
                    return repo.display_name?repo.display_name:''
                }
            });
            if (item) {
                $('#selectPid').val([item.id]).trigger('change');
            }
        })
    </script>
@endsection