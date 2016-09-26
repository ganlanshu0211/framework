@extends('install::layout')
@section('content')
    <div class="main-viewport install-success">
        <header>
            <div class="container">
                <img class="success-logo" src="{{ asset('assets/install/images/install-success.svg') }}">
                <h1 class="error-title">完成安装</h1>
            </div>
        </header>
        <main>
            <div class="container">
                <div class="error-panel">
                    <ul class="install-info">
                        <li>
                            <label for="address">后台管理地址：</label><a href="#"><span id="address">http://www.aaa.com/admin</span></a>
                        </li>
                        <li><label for="index">前台首页：</label><a href="#"><span id="index">http://www.aaa.com</span></a>
                        </li>
                        <li class="finish"><label for="account">账号：</label><span id="account">admin@email.com</span>
                        </li>
                        <li class="finish"><label for="psw">密码：</label><span id="psw">您设定的密码</span></li>
                        <li class="finish">
                            <label for="help">获取帮助：</label><a href="https://www.notadd.com"><span id="help" style="color: #1BC9A8">点此获取帮助</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
@endsection