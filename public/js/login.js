function validatePhoneNumber(input_str) 
{
    var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

    return re.test(input_str);
}

function validatePhone(e) 
{
    var phone = e.value;
    if (!validatePhoneNumber(phone)) {
        document.getElementById('phone_error').classList.remove('hidden');
    } else {
        document.getElementById('phone_error').classList.add('hidden');
    }
}

function check(e)
{
    if(e.value.indexOf(' ') >= 0) {
        if(e.getAttribute('name') == 'txt-name')
            document.getElementById('name_error').classList.remove('hidden');
        else
        document.getElementById('password_error').classList.remove('hidden');
    } else {
        if(e.getAttribute('name') == 'txt-name')
             document.getElementById('name_error').classList.add('hidden');
        else
            document.getElementById('password_error').classList.add('hidden');
    }
}

function hideShow(e) 
{
    let pw = document.getElementById('my_password');
    if(pw.getAttribute('type') == 'password') {
        pw.setAttribute('type', 'text');
        document.getElementById('pwSignUp').innerText = 'Hide password';
    } else {
        pw.setAttribute('type', 'password');
        document.getElementById('pwSignUp').innerText = 'Show password';

    }
}

function hideShowPW(e)
{
    let pwLogin = document.getElementById('my_pw_login');
    if(pwLogin.getAttribute('type') == 'password') {
        pwLogin.setAttribute('type', 'text');
        document.getElementById('pwSignIn').innerText = 'Hide password';
    } else {
        pwLogin.setAttribute('type', 'password');
        document.getElementById('pwSignIn').innerText = 'Show password';
    }
}