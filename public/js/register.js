var DOM = {
    registerBtn: '#submit',
    inputErrorMsg: '#error-',
    usernameInput: '#username',
    passwordInput: '#password',
    confirmPassInput: '#confirm_password',
    userID: '.user-id',
};


var submitBtn = document.querySelector(DOM.registerBtn);

submitBtn.addEventListener('click', function(e) {

    e.preventDefault();
    var Inputs= {
        'username' : '#username',
        'password' : '#password',
    } ;
    var usernameInput = document.querySelector(DOM.usernameInput);
    var passwordInput = document.querySelector(DOM.passwordInput);
    var inputErrorUsername = document.querySelector(DOM.inputErrorMsg+'username');
    var inputErrorPass = document.querySelector(DOM.inputErrorMsg+'password');

    removeErrMsg(inputErrorUsername, usernameInput);
    removeErrMsg(inputErrorPass, passwordInput);

    var username = document.querySelector(DOM.usernameInput).value;
    var password = document.querySelector(DOM.passwordInput).value;
    var confirmPass = document.querySelector(DOM.confirmPassInput).value;

    ajaxCreate({username:username, password:password, confirm_password:confirmPass}, g.registerModel)
        .then(function(data) {
            window.location.href = data.redirectTo
        })
        .catch(function(error) {
            console.log(error.errors)
            for (const [key, value] of Object.entries(error.errors)) {
                if (key === 'username') displayErrMsg(value, inputErrorUsername, usernameInput);
                if (key === 'password') displayErrMsg(value, inputErrorPass, passwordInput);
            }
            console.log('error adding board');
        })
    ;
});




/*******************************************
GENERIC FUNCTIONS
*******************************************/

function displayErrMsg(msg, errorTextField, inputField) {
    inputField.classList.add('error-field');
    errorTextField.textContent = msg;
    errorTextField.classList.remove('hide');
}

function removeErrMsg(errorTextField, inputField) {
    inputField.classList.remove('error-field');
    errorTextField.textContent = "";
    errorTextField.classList.add('hide');
}













