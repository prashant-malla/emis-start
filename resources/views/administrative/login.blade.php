<!DOCTYPE html>
<html lang="en">
@include('includes.login_head')
<body>
<section class="login">
    <div class="container">
        <div class="login-wrapper">
            <div class="row g-0">
                <div class="col-md-6 col-12">
                    <div class="login-slider owl-carousel owl-theme h-100">
                        <div class="login-info">
                            <h3 class="text-white fw-light mb-4">{{ $school_setting->name }}</h3>
                            <img src="{{asset('images/illus.png')}}" alt="">
                            <div class="login-wrapper-footer text-white mt-4">
                                <h4>Welcome</h4>
                                <p>Enter your personal details and start your journey with us</p>
                            </div>
                        </div>
                        <div class="login-info">
                            <h3 class="text-white fw-light mb-4">{{ $school_setting->name }}</h3>
                            <img src="{{asset('images/illus.png')}}" alt="">
                            <div class="login-wrapper-footer text-white mt-4">
                                <h4 class="fw-normal">Welcome</h4>
                                <p>Enter your personal details and start your journey with us</p>
                            </div>
                        </div>
                        <div class="login-info">
                            <h3 class="text-white fw-light mb-4">{{ $school_setting->name }}</h3>
                            <img src="{{asset('images/illus.png')}}" alt="">
                            <div class="login-wrapper-footer text-white mt-4">
                                <h4>Welcome</h4>
                                <p >Enter your personal details and start your journey with us</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="main-login h-100">
                        <h3 class="pt-5">Administrative Log In</h3>
                        <div class="login-form my-4">
                            <form action="{{route('administrative.login')}}" method="POST" class="login-form">
                                @csrf
                                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" value="{{old('email')}}"
                                       placeholder="Email">
                                <i class="fas fa-eye-slash" onclick="myFunction()" id="eyePassword"></i>
                                <input type="password" name="password" class="form-control" id="exampleFormControlInput2"
                                       placeholder="Password">
                                <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Remember Me
                                    </label>
                                </div>
                                <div class="d-flex align-items-center my-4">
                                    <button type="submit" class="main-btn me-5">Sign in</button>
                                </div>
                            </form>
                            <div class="text-center mb-5">
                                <a class="password-link" href="">Forget Password?</a>
                            </div>
{{--                            <p>Powered by IET Technology</p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="logo">
        <img src="{{ $school_setting->logo_url }}" alt="{{ $school_setting->title }}">
    </div>
</section>
</body>

<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script>
    function myFunction() {
        console.log()
        var x = document.getElementById("exampleFormControlInput2");
        if (x.type === "password") {
            x.type = "text";
            $('#eyePassword').removeClass('fa-eye-slash');
            $('#eyePassword').addClass('fa-eye');
        } else {
            x.type = "password";
            $('#eyePassword').removeClass('fa-eye');
            $('#eyePassword').addClass('fa-eye-slash');
        }
    }
</script>
<script>
    $('.login-slider').owlCarousel({
        loop: true,
        margin: 30,
        dots: true,
        nav: false,
        items: 1,
    })
</script>
</html>
