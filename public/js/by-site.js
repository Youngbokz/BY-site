//Full screen navbar Open and close
function openMyNav() {
    document.getElementById('my_nav').style.height = "100%";
    document.getElementById('myBurger').style.display = 'none';
}
function closeMyNav() {
    document.getElementById('my_nav').style.height = "0%";
    document.getElementById('myBurger').style.display = 'block';
}

//NavBar on scroll
$(window).on('scroll', function () {
    if ($(window).scrollTop()) {
        $('#mainNav').addClass('black');
    }
    else {
        $('#mainNav').removeClass('black')
    }
})
// Report a message in Show project page
function onClickBtnReport(e) {
    e.preventDefault();
    var btn = $(this);
    var url = btn.attr('href');
    // console.log(url);
    if (btn.hasClass('reported')) {
        btn.removeClass('reported');
    }
    else {
        btn.addClass('reported');
    }
    $.get(url);
}
$('.js-report').on('click', onClickBtnReport);

//Success message using sweet alert

// function onSubmitBtnConnexion() {
//     var successMessage = swal("Good job!", "You clicked the button!", "success");

// }
// $('#submitConnexion').on('click', onSubmitBtnConnexion);
