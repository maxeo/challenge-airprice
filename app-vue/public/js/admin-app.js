Array.from(document.querySelectorAll('.main > .navbar > .sidebar-toggle')).forEach((function (t) {
    t.addEventListener('click', () => {
        document.querySelector('#sidebar').classList.toggle('collapsed')
    })
}));

Array.from(document.querySelectorAll('.main > .navbar .navbar-nav .dropdown-toggle')).forEach((function (t) {
    t.addEventListener('click', () => {
        let dm = t.parentNode.querySelector('.dropdown-menu');
        t.classList.toggle('show');
        dm.classList.toggle('show');
    })
}));
