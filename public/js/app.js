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

    Array.prototype.cleanUndefined = function ()
    {


        var l = this.length;
        var c = 0;
        var tmp = []
        var i = 0;

        while (c < l)
        {
            //console.log(this[c]);

            if (this[c] !== undefined)
            {
                tmp[i] = this[c];
                i++;
            }

            c++;
        }

        return tmp;

    }


})(window);
