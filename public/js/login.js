var DOM = {
    loginBtn: '#submit',
    inputAlertMsg: '.alert',
    usernameInput: '#username',
    passwordInput: '#password',
    rememberMe: '#remember_me',
    userID: '.user-id',
    submitBtn: '#submit'
};

var submitBtn = document.querySelector(DOM.loginBtn);

submitBtn.addEventListener('click', function(e) {

    e.preventDefault();
    var rememberMeCheckBox = document.querySelector(DOM.rememberMe);
    console.log(rememberMeCheckBox);
    var submitButton = this;

    var inputs = [
        document.querySelector(DOM.usernameInput),
        document.querySelector(DOM.passwordInput)
    ];
    submitButton.disabled = true;
    inputs[0].disabled = true;
    inputs[1].disabled = true;
    rememberMeCheckBox.disabled = true;

    console.log(rememberMeCheckBox)

    var inputAlert = document.querySelector(DOM.inputAlertMsg);

    removeErrMsg(inputAlert, inputs);
    var username = document.querySelector(DOM.usernameInput).value;
    var password = document.querySelector(DOM.passwordInput).value;
    var rememberMe = document.querySelector(DOM.rememberMe).checked;

    console.log(rememberMe);
    ajaxSubmit({username:username, password:password, rememberMe:rememberMe}, g.registerModel)
        .then(function(data) {
            displaySuccessMsg(data.result, inputAlert, inputs)
            setTimeout(function(){ window.location.href = data.redirectTo; }, 1000);

        })
        .catch(function(error) {
            console.log(error.errors)
            displayErrMsg(error.errors, inputAlert, inputs)
            console.log('error adding board');

            submitButton.disabled = false;
            inputs[0].disabled = false;
            inputs[1].disabled = false;
            rememberMeCheckBox.disabled = false;
        })
    ;
});

/*******************************************
GENERIC FUNCTIONS
*******************************************/

function displayErrMsg(msg, alertTextField, inputFields) {
    for (let field of inputFields) {
        field.classList.add('error-field');
    }
    alertTextField.textContent = msg;
    alertTextField.classList.remove('hide');
}

function removeErrMsg(alertTextField, inputFields) {
    for (let field of inputFields) {
        field.classList.remove('error-field');
    }
    alertTextField.textContent = "";
    alertTextField.classList.add('hide');
}

function displaySuccessMsg(msg, alertTextField, inputFields) {
    alertTextField.textContent = msg;
    alertTextField.classList.remove('err-msg-text', 'alert-danger');
    alertTextField.classList.add('alert-success');
    alertTextField.classList.remove('hide');
}













