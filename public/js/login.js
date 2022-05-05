function validatePhone(e) 
{
    var phone = e.value.trim();
    var isNum = isNaN(phone);
    var name = e.getAttribute('class');
    var btn = document.querySelectorAll('.login-form .btn')[0]
    
    if (isNum) {
        document.getElementById(name).classList.remove('hidden');
        document.getElementById(name).innerText = 'Phone number does not contain characters';
        btn.disabled = true;
    } else {
        document.getElementById(name).classList.add('hidden');
        btn.disabled = false;

    }

    if(phone.length > 10) {
        document.getElementById(name).classList.remove('hidden');
        document.getElementById(name).innerText = 'Phone number must not exceed 10 digits';
        btn.disabled = true;

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