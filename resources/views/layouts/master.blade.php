<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.header')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>
<body>
<!------------------------------------- Wrapper Starts ------------------------------------->
<div id="wrapper">
    <div id="main-wrapper">
    <!--------------------------------- Header Wrapper Starts ---------------------------------->
    @include('includes.navbar')

    <!---------------------------------- Header Wrapper Ends ----------------------------------->

    <!-------------------------------- Content Wrapper Starts ---------------------------------->
    <div id="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>
    <!--------------------------------- Content Wrapper Ends ----------------------------------->


    <!--------------------------------- Footer Wrapper Starts ---------------------------------->
    <footer id="footer-wrapper">
        @include('includes.footer')
    </footer>

    <!---------------------------------- Footer Wrapper Ends ----------------------------------->
</div>
<!-------------------------------------- Wrapper Ends -------------------------------------->
<!--**********************************
      Scripts
  ***********************************-->
@include('includes.scripts')
@yield('scripts')
@stack('scripts')
</body>
</html>
