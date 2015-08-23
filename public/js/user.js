var User = {
    enable: function (button, user_id) {

        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/enable';

        ajax.get(url_req)
                .done(function (response, xhr) {
                    button.className = 'active';
                    button.setAttribute('onclick', 'User.disable(this, ' + user_id + ')');
                });
        /*var xhr = new XMLHttpRequest();
         xhr.open("GET", url + 'user/' + user_id + '/enable', true);
         xhr.onload = function (e) {
         if (xhr.readyState === 4) {
         if (xhr.status === 200) {
         button.className = 'active';
         button.setAttribute('onclick', 'User.disable(this, ' + user_id + ')');
         }
         }
         };
         xhr.send(null);*/
    },
    disable: function (button, user_id) {

        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/disable';

        ajax.get(url_req)
                .done(function (response, xhr) {
                    button.className = 'noactive';
                    button.setAttribute('onclick', 'User.enable(this, ' + user_id + ')');
                });

        /*var xhr = new XMLHttpRequest();
         xhr.open("GET", url + 'user/' + user_id + '/disable', true);
         xhr.onload = function (e) {
         if (xhr.readyState === 4) {
         if (xhr.status === 200) {
         button.className = 'noactive';
         button.setAttribute('onclick', 'User.enable(this, ' + user_id + ')');
         }
         }
         };
         xhr.send(null);*/
    },
    setPassword: function (button, user_id, user_name)
    {
        var passDialog = document.getElementById('changePasswordDialog');
        
        //var overlay = document.createElement('div');
        //overlay.setAttribute('id', 'overlay');
        //overlay.innerHTML = "<h1></h1><div></div><div><a href=\"#\">chiudi</a></div>";

        passDialog.dialog({
            name: 'password change for '+ user_name + '...',
            buttons: {
                exit: function (element)
                {
                    //alert(element);
                    document.body.removeChild(element);
                },
                change: function (element)
                {
                    console.log(user_id);
                }
            }
        });
        //overlay.style.visibility = "visible";

        //document.body.appendChild(overlay);

    },
    delete: function (button, user_id, user_name)
    {
        var deleteDialog = document.getElementById('deleteDialog');

        var message = new String(deleteDialog.innerHTML);

        //console.log(message);
        deleteDialog.innerHTML = message.replace('_username_', user_name);


        deleteDialog.dialog({
            name: 'delete?',
            buttons: {
                exit: function (element)
                {
                    document.body.removeChild(element);
                    deleteDialog.innerHTML = message;
                },
                confirm: function (element) {

                    var ajax = new Ajax();
                    var url_req = url + 'user/' + user_id + '/delete';
                    
                    ajax.get(url_req)
                            .done(function (response, xhr) {
                                
                                var tr = button.parentNode.parentNode;
                                var tbody = tr.parentNode;
                                
                                tbody.removeChild(tr);                             
                                
                            });
                            
                    document.body.removeChild(element);
                    deleteDialog.innerHTML = message;
                }
            }
        });
    }
};

