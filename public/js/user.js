var User = {
    enable: function (button, user_id) {

        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/enable';

        ajax.get(url_req)
                .done(function (response, xhr) {
                    button.className = 'active';
                    button.setAttribute('onclick', 'User.disable(this, ' + user_id + ')');
                });
    },
    
    disable: function (button, user_id) {

        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/disable';

        ajax.get(url_req)
                .done(function (response, xhr) {
                    button.className = 'noactive';
                    button.setAttribute('onclick', 'User.enable(this, ' + user_id + ')');
                });
    },
    
    setPassword: function (button, user_id, user_name)
    {
        var passDialog = document.getElementById('changePasswordDialog');
        
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
    },
    
    delete: function (button, user_id, user_name)
    {
        var deleteDialog = document.getElementById('deleteDialog');

        var message = new String(deleteDialog.innerHTML);

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

