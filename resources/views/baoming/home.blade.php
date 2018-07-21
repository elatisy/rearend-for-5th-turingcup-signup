@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div style="margin-left:35%;width: 25%">
    <form action="javascript:judge();" id="baoming" >
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>姓名</label>
            <input class="form-control" name="name" />
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>性别</label><br/>
            <input type="radio" name="sex" value="male" checked />男
            <input type="radio" name="sex" value="female" style="margin-left:50px" />女
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>电话号码</label>
            <input class="form-control" name="phone"/>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>邮箱</label>
            <input class="form-control" name="email" />
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>学号</label>
            <input class="form-control" name="xuehao" />
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>学院</label>
            <input class="form-control" name="college" />
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"><span style="color:red">*</span>专业</label>
            <input class="form-control" name="major" />
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">&nbsp备注</label>
            <input class="form-control" name="beizhu" />
        </div>
        <div style="text-align:center;">
            <button type="submit" class="btn btn-primary">
                                    提交
            </button>
        </div>
    </form>
    <div style="text-align:center;">
        <button type="submit" class="btn btn-primary" onclick="showTable();" >
            获取整个表
        </button>
    </div>
</div>
@endsection
<script src="https://cdn.bootcss.com/react/15.4.2/react.min.js"></script>
<script src="https://cdn.bootcss.com/react/15.4.2/react-dom.min.js"></script>
<script src="https://cdn.bootcss.com/babel-standalone/6.22.1/babel.min.js"></script>
<script type="text/babel">
    function judge(){
        let Form = document.getElementById("baoming");
        let form_data = {};
        let inputs = Form.getElementsByTagName('input');
        for(let i = 0;i < inputs.length; ++i){
            form_data[inputs[i].name] = inputs[i].value;
        }
            fetch('baoming',{
                method:     'POST',
                headers: {
                            "Content-Type": "text/json"
                },
                body:       JSON.stringify(form_data),
            }).then(function(res){
                if(res.status != 200){
                    console.log("Error, status: " + res.status);
                    return;
                }else{
                    console.log("Success, status: " + res.status);
                    return res;
                }
            }).then(function(res){
                console.log(res.json());
            }).catch(function(err){
                console.log("Fetch error: " + err);
            })
    }

    function showTable() {
        fetch('baoming/show',{
            method:     'POST',
        }).then(function(res){
            if(res.status != 200){
                console.log("Error, status: " + res.status);
                return;
            }else{
                console.log("Success, status: " + res.status);
                return res;
            }
        }).then(function(res){
            console.log(res.json());
        }).catch(function(err){
            console.log("Fetch error: " + err);
        })
    }
    
</script>