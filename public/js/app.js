(function (window) {

    "use strict";

    var nav = {};

    nav.body = document.body;
    nav.menuButton = document.querySelectorAll("header a.home")[0];//document.getElementById("dropdownHomeButton");


    nav.menuButton.addEventListener("click", function () {
        nav.body.classList.add("dropdownMenuOpen");
    });


    /* hide active menu if close menu button is clicked */
    [].slice.call(document.querySelectorAll(".closeNav")).forEach(function (el, i) {
        el.addEventListener("click", function () {
            nav.body.classList.remove("dropdownMenuOpen");
        });
    });

})(window);
