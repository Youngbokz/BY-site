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
        alert("Was preventDefault() called: " + event.isDefaultPrevented());
        const url = this.href;
        const icone = this.querySelector('i');
        const btnTitle = this.querySelector('span.js-btnTitle');

        $(url).get().then(function (response) {
            if (icone.classList.contains('far')) {
                icone.classList.replace('far', 'fas');
                icone.classList.replace('fa-times-circle', 'fa-heartbeat');
                btnTitle.text(response.data.btnTitle);
                $('.a.js-report').css({ background: 'orange' });
            }
            else {
                icone.classList.replace('fas', 'far');
                icone.classList.replace('fa-heartbeat', 'fa-times-circle');
                btnTitle.text(response.data.btnTitle);
                $('.a.js-report').css({ background: 'red' });
            }
        })

    }
    $('a[class="js-report"]').each(function (link) {
        link.on('click', onClickBtnReport);
    })
})
