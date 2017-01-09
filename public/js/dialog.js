/**
 * Linna App
 *
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

'use strict';

//http://lea.verou.me/2015/04/idea-extending-native-dom-prototypes-without-collisions/

var dialog = function (element) {
    this.element = element;
};

dialog.prototype = {
    buttonBar: null,
    currentOverlay: null,
    currentElementId: null,
    _generateUnOverlay() {

        var d = new Date();
        var n = d.getTime();

        var o = document.createElement('div');
        o.setAttribute('id', 'overlay_' + n);
        o.classList.add('overlay');

        //console.log(this);
        this.currentOverlay = o;

        return o;
    },
    
    removeButton(buttonId)
    {
        //console.log(this.buttonBar);
        this.buttonBar.removeChild(document.getElementById(buttonId));
    },
    
    close() {

        this.element.id = this.currentElementId;
        this.element.classList.remove('content');
        this.element.removeAttribute('class');

        document.querySelector('main').appendChild(this.element);

        document.body.removeChild(this.currentOverlay);
    },
    open(options) {
        
       
        var dialogHeader = null;
        var dialogButtons = null;

        this.element.classList.add('content');

        this.currentElementId = this.element.id;

        this.element.removeAttribute('id');


        var buttonAddEvent = function (buttonEl, i) {
            buttonEl.addEventListener('click', function (e) {
                i(overlay);
            }, false);
        };

        for (var opt in options)
        {
            if (opt === 'name')
            {
                var h = document.createElement('h1');
                h.innerHTML = options[opt];

                dialogHeader = h;
            }

            if (opt === 'buttons')
            {
                var button = options[opt];

                dialogButtons = document.createElement('div');
                dialogButtons.classList.add('buttons');
                
                this.buttonBar = dialogButtons;
                
                for (var btn in button)
                {
                    var currentCallback = button[btn];
                    var b = document.createElement('button');

                    b.innerHTML = btn;
                    b.setAttribute('id', 'dButton_' + btn);

                    buttonAddEvent(b, currentCallback);

                    dialogButtons.appendChild(b);
                }

            }
        }

        var overlayContent = document.createElement('div');

        overlayContent.classList.add('dialog');

        overlayContent.appendChild(dialogHeader);
        overlayContent.appendChild(this.element);
        overlayContent.appendChild(dialogButtons);


        var overlay = this._generateUnOverlay();

        overlay.appendChild(overlayContent);
        overlay.style.visibility = "visible";

        document.body.appendChild(overlay);
    }
};


Object.defineProperty(Element.prototype, "dialog", {
    get() {
        Object.defineProperty(this, "dialog", {
            value: new dialog(this)
        });

        return this.dialog;
    },
    configurable: true,
    writeable: false
});
