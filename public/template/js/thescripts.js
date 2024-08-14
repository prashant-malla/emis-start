var winWidth = $(window).width();

$(document).ready(function () {
  sliderInit();
  addClassInit();
  navInit();
  mcustomInit();
  matchHeight();
  dataTable();
});

/*------------------------------- Functions Starts -------------------------------*/
function sliderInit() {
  /*$('.common-banner-slider').slick({
        arrows: false,
        dots: true,
        autoplay: false,
        speed: 500,
        fade: true,
        pauseOnHover: false,
        cssEase: 'linear',
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 667,
                settings: {
                    arrows: true,
                    dots: false
                }
            }
        ]
    });*/
}

function addClassInit() {}

function navInit() {}

function mcustomInit() {}

function dataTable() {}
/*-------------------------------- Functions Ends --------------------------------*/

const navItems = document.querySelectorAll(".main-sidebar-navitem");
const navLink = document.querySelector(".main-sidebar-navlink");
const dropdownList = document.querySelector(
  ".main-sidebar-navitem .main-sidebar-dropdown-list"
);

// navItem.addEventListener("click", () => {
//   dropdownList.classList.toggle("show");
//   navLink.classList.toggle("active");
// });

navItems.forEach((navItem) => {
  navItem.addEventListener("click", () => {
    dropdownList.classList.toggle("show");
    navLink.classList.toggle("active");
  });
});

// script for toggling the profile-box in navbar
$(".profile").click(function () {
  $(".profile-box").toggleClass("show");
});

$(document).ready(function () {
  $("#example").DataTable({
    dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "pdf", "print"],
  });
});

function confirmBox() {
  return confirm("Delete Confirm?");
}
// const button1 = document.querySelector(".buttons-copy");
// button1.setAttribute("title", "copy");
