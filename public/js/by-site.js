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


function onClickBtnReport(e) {
    e.preventDefault();
    const url = this.href;
    const icone = this.querySelector('i');
    const btnTitle = this.querySelector('span.js-btnTitle');

    axios.get(url).then(function (response) {
        if (icone.classList.contains('far')) {
            icone.classList.replace('far', 'fas');
            icone.classList.replace('fa-times-circle', 'fa-heartbeat');
            btnTitle.textContent = 'Rétablir pour ne pas signaler';
        }
        else {
            icone.classList.replace('fas', 'far');
            icone.classList.replace('fa-heartbeat', 'fa-times-circle');
            btnTitle.textContent = 'Signaler';
        }
    })
}
document.querySelectorAll('a.js-report').forEach(function (link) {
    link.addEventListener('click', onClickBtnReport);
})