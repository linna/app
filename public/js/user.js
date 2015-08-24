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
        
        passDialog.dialog.open({
            name: 'password change for ' + user_name + '...',
            buttons: {
                exit: function (element)
                {
                   passDialog.dialog.close();
                },
                change: function (element)
                {
                    User._doChangePassword(element, button, user_id);
                    
                    passDialog.dialog.close();
                }
            }
        });
    },
    
    delete: function (button, user_id, user_name)
    {
        var deleteDialog = document.getElementById('deleteDialog');

        var message = new String(deleteDialog.innerHTML);

        deleteDialog.innerHTML = message.replace('_username_', user_name);

        deleteDialog.dialog.open({
            name: 'delete?',
            buttons: {
                exit: function (element)
                {
                    deleteDialog.dialog.close();
                    deleteDialog.innerHTML = message;
                },
                confirm: function (element) {

                    User._doDelete(element, button, user_id);

                    deleteDialog.dialog.close();
                    
                    deleteDialog.innerHTML = message;
                }
            }
        });
    },
    
    _doDelete: function (element, button, user_id) {

        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/delete';

        ajax.get(url_req)
                .done(function (response, xhr) {

                    var tr = button.parentNode.parentNode;
                    var tbody = tr.parentNode;

                    tbody.removeChild(tr);

                });
    },
    
    _doChangePassword: function (element, button, user_id) {

        var newPassword = document.getElementById('newpassword').value;
        var confirmPassword = document.getElementById('confirmpassword').value;
        
        
        console.log(newPassword +' '+ confirmPassword);
    }
};

