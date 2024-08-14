<!DOCTYPE html>
<html lang="en">
@include('includes.login_head')
<body style="margin: 0px;">
<div id="login-page" class="common-background-page" style="background-image: url({{ asset('template/images/background.jpg') }}); background-size: cover;">
    <div class="login-box">
        <div class="login-box-wrapper">
            <div class="header">
                <div class="logo">
                    <img src="{{ asset('template/images/logo/spa_logo.png') }}" alt="{{ config('app.name') }}" style="height: 120px;">
                </div>
            </div>
            <div class="content">
                <h3 class="form-title">Admin Login</h3>
                <form action="{{route('login')}}" method="POST" class="login-form">
                    @csrf
                    <div class="username input-item">
                        <input type="text" class="form-control" name="email" id="username" placeholder="Username">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        <span class="text-danger">@error('email'){{$message}} @enderror</span>
                    </div>
                    <div class="password input-item">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <span class="text-danger">@error('password'){{$message}} @enderror</span>
                    </div>
                    <button class="btn" type="submit" style="background-color: #581845">Sign In</button>
                </form>
                <a href="#" class="forgot-password-link">
                    <i class="fa-solid fa-unlock-keyhole"></i>
                    Forgot Password
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
