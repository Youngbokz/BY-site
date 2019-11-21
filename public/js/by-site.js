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




// function onClickBtnReport(e) {
//     e.preventDefault();
//     const url = $(this).attr(href);

//     $.get(url).then(function (response) {
//         console.log(response);
//     })
// }
// $('a[class="js-report"]').each(function (link) {
//     link.addEventListener('click', onClickBtnReport);
// })

$(function () {
    function onClickBtnReport(e) {
        e.preventDefault();
        const icone = $("i.far.fa-times-circle");
        var classReport = 'far fa-times-circle';
        var classBack = 'fas fa-heartbeat';
        const btnTitle = $('span.js-btnTitle');

        if (icone) {
            icone.removeClass(classReport);
            icone.addClass(classBack);
            btnTitle.text('Rétablir pour ne plus signaler');
            $('.js-report').css({ background: 'orange' });
        }
        else {
            icone.removeClass(classBack);
            icone.addClass(classReport);
            btnTitle.text('Signaler');
            $('.js-report').css({ background: 'red' });
        }
    }
    $('.js-report').on('click', onClickBtnReport);
})
