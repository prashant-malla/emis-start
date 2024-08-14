<!DOCTYPE html>
<html lang="en">
@include('includes.login_head')
<body>
<section class="login">
    <div class="container">
        <div class="login-wrapper">
            <div class="row g-0">
                <div class="col-md-6 col-12">
                    <div class="login-left h-100">
                        <div class="login-info">
                            <h4 class="text-white text-uppercase">{{ $school_setting->name }}</h4>
                            <div class="login-slider owl-carousel owl-theme">
                                <img src="{{asset('images/illus.png')}}" width="200">
                                <img src="{{asset('images/illus.png')}}" width="200">
                            </div>
                            <div class="login-wrapper-footer text-white mt-2">
                                <h4>Welcome</h4>
                                <p class="mb-0">Enter your personal details and start your journey with us</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="main-login h-100">
                        <div>
                            <p class="mb-2">Hello <span class="text-primary">Super Admin</span>!</p>
                            <h4 class="pb-3 pb-xxl-4">Login to your Account</h4>
                            <div class="login-form">
                                <form action="{{route('login')}}" method="POST" class="login-form">
                                @csrf
                                    <input type="email" name="email" class="form-control" id="exampleFormControlInput1" value="{{old('email')}}"
                                        placeholder="Email">
                                    <div class="position-relative">
                                        <i class="fas fa-eye-slash" onclick="showHidePassword()" id="eyePassword"></i>
                                        <input type="password" name="password" class="form-control" id="exampleFormControlInput2"
                                            placeholder="Password">
                                    </div>
                                    <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Remember Me
                                        </label>
                                    </div>
                                <div class="d-flex align-items-center my-4">
                                    <button type="submit" class="main-btn">Sign in</button>
                                </div>
                                </form>
                                <div class="text-center">
                                    <a class="password-link" href="">Forget Password?</a>
                                </div>
                            </div>
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
    function showHidePassword() {
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
        nav: false,
        items: 1,
        autoplay:true
    })
</script>

</html>
