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
    changePassword: function (button, user_id, user_name)
    {
        var passDialog = document.getElementById('changePasswordDialog');
        
        passDialog.dialog.open({
            name: 'password change for ' + user_name + '...',
            buttons: {
                exit: function ()
                {
                    passDialog.dialog.close();
                    document.getElementById('newpassword').value = '';
                    document.getElementById('confirmpassword').value = '';
                },
                change: function ()
                {
                    User._doChangePassword(passDialog, user_id);
                }
            }
        });
        
        User._cleanPasswordForm();
    },
    delete: function (button, user_id, user_name)
    {
        var deleteDialog = document.getElementById('deleteDialog');
        var message = new String(deleteDialog.innerHTML);
        deleteDialog.innerHTML = message.replace('_username_', user_name);
        deleteDialog.dialog.open({
            name: 'delete?',
            buttons: {
                exit: function ()
                {
                    deleteDialog.dialog.close();
                    deleteDialog.innerHTML = message;
                },
                confirm: function () {

                    User._doDelete(button, user_id);
                    deleteDialog.dialog.close();
                    deleteDialog.innerHTML = message;
                }
            }
        });
    },
    _cleanPasswordForm: function ()
    {
        var messages = document.querySelectorAll('.message');
        var dialogContent = document.querySelector('.content');
        [].slice.call(messages).forEach(function (el, i) {
            
                dialogContent.removeChild(el);
        });
    },
    _doDelete: function (button, user_id) {

        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/delete';
        ajax.get(url_req)
                .done(function (response, xhr) {

                    var tr = button.parentNode.parentNode;
                    var tbody = tr.parentNode;
                    tbody.removeChild(tr);
                });
    },
    _doChangePassword: function (passDialog, user_id) {

        var newPassword = document.getElementById('newpassword');
        var confirmPassword = document.getElementById('confirmpassword');
        var ajax = new Ajax();
        var url_req = url + 'user/' + user_id + '/changePassword';
        var data = {
            new_password: newPassword.value,
            confirm_password: confirmPassword.value
        };
        ajax.post(url_req, data)
                .done(function (response, xhr) {
                    
                    User._cleanPasswordForm();
                    
                    var dialogContent = document.querySelector('.content');

                    var div = document.createElement('div');
                    div.classList.add('message');

                    switch (response) {
                        case 2:
                            div.innerHTML = 'please choose a new password :|';
                            div.classList.add('alert');
                            dialogContent.appendChild(div);
                            break;
                        case 1:
                            div.innerHTML = 'new password and confirm password are different :(';
                            div.classList.add('error');
                            dialogContent.appendChild(div);
                            break;
                        case 0:
                            div.classList.add('success');
                            div.innerHTML = 'password succesfully changed :)';
                            dialogContent.appendChild(div);
                            passDialog.dialog.removeButton('dButton_change');
                            newPassword.value = '';
                            confirmPassword.value = '';
                            break;
                    }
                });
    }
};

