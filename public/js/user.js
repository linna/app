/**
 * Linna App
 *
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

"use strict";

var User = {
    modOldUserName: {},
    modOldUserDescription: {},
    modButtonCancel: {},
    modButtonSave: {},
    enable(button, userId) {
        this.changeState("enable", userId, button);
    },
    disable(button, userId) {
        this.changeState("disable", userId, button);
    },
    changeState(state, userId, button)
    {
        var ajax = new Ajax();
        var urlReq = URL + "user/" + userId + "/"+ state;
        ajax.get(urlReq)
                .done(function (response, xhr) {
                    button.className = (state === "enable") ? "active" : "noactive";
                    var callMethod = (state === "enable") ? "disable" : "enable";
                    button.setAttribute("onclick", "User."+ callMethod +"(this, " + userId + ")");
                });
    },
    changePassword(button, userId, userName)
    {
        var passDialog = document.getElementById("changePasswordDialog");

        passDialog.dialog.open({
            name: "password change for " + userName + "...",
            buttons: {
                exit: function ()
                {
                    passDialog.dialog.close();
                    document.getElementById("newpassword").value = "";
                    document.getElementById("confirmpassword").value = "";
                },
                change: function ()
                {
                    User._doChangePassword(passDialog, userId);
                }
            }
        });

        User._cleanPasswordForm();
    },
    modify(button, userId)
    {
        var tr = button.parentNode.parentNode;

        this._createModifyForm(tr, userId);
        this._createButtonModifyForm(tr, userId);

    },
    modifySave(button, userId) {

        var td = button.parentNode;
        var tr = td.parentNode;

        var newUserName = document.getElementById("newusername_" + userId);
        var newUserDescription = document.getElementById("newuserdescription_" + userId);

        var ajax = new Ajax();
        var url_req = URL + "user/" + userId + "/modify";
        var data = {
            new_user_name: newUserName.value,
            new_user_description: newUserDescription.value
        };

        ajax.post(url_req, data)
                .done(function (response, xhr) {

                    User._cleanModifyTd(td);

                    var errorArray = ["","this user name already present :(","please choose a new user name :|"];
                    var classArray = ["","error","alert"];
                    
                    var div = document.createElement("div");
                    div.classList.add("message");
                    div.style.textAlign = "right";
                    div.style = "text-align:left; margin-left: 0px; font-size:12px;"
                    
                    if (response.error === 0)
                    {
                        tr.cells[0].innerHTML = data.new_user_name;
                        tr.cells[1].innerHTML = data.new_user_description;
                        User._modifyExitAfterSave(button, userId);
                    }
                    
                    if (response.error > 0)
                    {
                        div.innerHTML = errorArray[response.error];
                        div.classList.add(classArray[response.error]);
                        td.insertBefore(div, td.firstChild);
                    }
                });
    },
    _modifyClear(userId) {

        delete this.modButtonCancel["user" + userId];
        delete this.modButtonSave["user" + userId];

        delete this.modOldUserName["user" + userId];
        delete this.modOldUserDescription["user" + userId];
    },
    _modifyExitAfterSave(button, userId) {

        var tr = button.parentNode.parentNode;
        var td = button.parentNode;

        var buttonCancel = this.modButtonCancel["user" + userId];
        var buttonSave = this.modButtonSave["user" + userId];


        td.removeChild(buttonCancel);
        td.removeChild(buttonSave);

        this._cleanModifyTd(td);
        this._modifyClear(userId);

    },
    modifyExit(button, userId) {

        var tr = button.parentNode.parentNode;
        var td = button.parentNode;

        var buttonCancel = this.modButtonCancel["user" + userId];
        var buttonSave = this.modButtonSave["user" + userId];


        td.removeChild(buttonCancel);
        td.removeChild(buttonSave);

        tr.cells[0].innerHTML = this.modOldUserName["user" + userId];
        tr.cells[1].innerHTML = this.modOldUserDescription["user" + userId];

        this._cleanModifyTd(td);
        this._modifyClear(userId);

    },
    _createModifyForm(tr, userId) {

        this.modOldUserName["user" + userId] = tr.cells[0].innerHTML;
        this.modOldUserDescription["user" + userId] = tr.cells[1].innerHTML;

        var inputUserName = document.createElement("input");
        var inputUserDescription = document.createElement("input");

        inputUserName.id = "newusername_" + userId;
        inputUserDescription.id = "newuserdescription_" + userId;

        inputUserName.value = tr.cells[0].innerHTML;
        inputUserDescription.value = tr.cells[1].innerHTML;

        inputUserName.setAttribute("size", 14);
        inputUserDescription.setAttribute("size", 34);

        tr.cells[0].innerHTML = "";
        tr.cells[1].innerHTML = "";

        tr.cells[0].appendChild(inputUserName);
        tr.cells[1].appendChild(inputUserDescription);


    },
    _createButtonModifyForm(tr, userId) {

        var buttonCancel = document.createElement("button");
        var buttonSave = document.createElement("button");

        buttonCancel.id = "userbuttonmodify_" + userId;
        buttonCancel.classList.add("icon");
        buttonCancel.classList.add("cross-16");
        buttonCancel.style.marginLeft = "10px";

        buttonSave.id = "userbuttonsave_" + userId;
        buttonSave.classList.add("icon");
        buttonSave.classList.add("save-16");

        buttonCancel.setAttribute("onclick", "User.modifyExit(this," + userId + ")");
        buttonSave.setAttribute("onclick", "User.modifySave(this," + userId + ")");

        this.modButtonCancel["user" + userId] = buttonCancel;
        this.modButtonSave["user" + userId] = buttonSave;


        tr.cells[4].appendChild(buttonCancel);
        tr.cells[4].appendChild(buttonSave);

    },
    delete(button, userId, userName)
    {
        var deleteDialog = document.getElementById("deleteDialog");
        var message = new String(deleteDialog.innerHTML);
        deleteDialog.innerHTML = message.replace("_username_", userName);
        deleteDialog.dialog.open({
            name: "delete?",
            buttons: {
                exit: function ()
                {
                    deleteDialog.dialog.close();
                    deleteDialog.innerHTML = message;
                },
                confirm: function () {

                    User._doDelete(button, userId);
                    deleteDialog.dialog.close();
                    deleteDialog.innerHTML = message;
                }
            }
        });
    },
    _cleanPasswordForm()
    {
        var messages = document.querySelectorAll(".message");
        var dialogContent = document.querySelector(".content");
        [].slice.call(messages).forEach(function (el, i) {

            dialogContent.removeChild(el);
        });
    },
    _cleanModifyTd(td)
    {
        var messages = document.querySelectorAll(".message");
        [].slice.call(messages).forEach(function (el, i) {
            if (td.contains(el))
            {
                td.removeChild(el);

            }
        });
    },
    _doDelete(button, userId) {

        var ajax = new Ajax();
        var url_req = URL + "user/" + userId + "/delete";
        ajax.get(url_req)
                .done(function (response, xhr) {

                    var tr = button.parentNode.parentNode;
                    var tbody = tr.parentNode;
                    tbody.removeChild(tr);
                });
    },
    _doChangePassword(passDialog, userId) {

        var newPassword = document.getElementById("newpassword");
        var confirmPassword = document.getElementById("confirmpassword");
        var ajax = new Ajax();
        var urlReq = URL + "user/" + userId + "/changePassword";
        var data = {
            new_password: newPassword.value,
            confirm_password: confirmPassword.value
        };
        ajax.post(urlReq, data)
                .done(function (response, xhr) {

                    User._cleanPasswordForm();
                    
                    var errorArray = ["","new password and confirm password are different :(","please choose a new password :|"];
                    var classArray = ["","error","alert"];
                    
                    var dialogContent = document.querySelector(".content");

                    var div = document.createElement("div");
                    div.classList.add("message");
                    
                    if (response.error === 0)
                    {
                        div.classList.add("success");
                        div.innerHTML = "password succesfully changed :)";
                        dialogContent.appendChild(div);
                        passDialog.dialog.removeButton("dButton_change");
                        newPassword.value = "";
                        confirmPassword.value = "";
                    }
                    
                    if (response.error > 0)
                    {
                        div.innerHTML = errorArray[response.error];
                        div.classList.add(classArray[response.error]);
                        dialogContent.appendChild(div);
                    }
                });
    }
};

