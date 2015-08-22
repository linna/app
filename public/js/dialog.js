'use strict';

Element.prototype.dialog = function (options)
{
    //this in this case refer to node when we apply dialog :);

    var dialogContent = null;
    var dialogHeader = null;
    var dialogButtons = null;
    
    dialogContent = document.createElement('div');
    dialogContent.innerHTML = this.innerHTML;
    
    var generateUnOverlay = function () {
        
        var d = new Date();
        var n = d.getTime();

        var o = document.createElement('div');
        o.setAttribute('id', 'overlay_'+n);
        o.classList.add('overlay');

        return o;
    };

    var buttonAddEvent = function (buttonEl, i) {
        buttonEl.addEventListener('click', function (e) {
            i(overlay);//currentCallback(overlay);
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
    
    overlayContent.appendChild(dialogHeader);
    overlayContent.appendChild(dialogContent);
    overlayContent.appendChild(dialogButtons);
    
    var overlay = generateUnOverlay();
    
    overlay.appendChild(overlayContent);
    
    document.body.appendChild(overlay);
    
    overlay.style.visibility = "visible";
    
};