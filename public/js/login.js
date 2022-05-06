function validatePhone(e) 
{
    var phone = e.value.trim();
    var isNum = isNaN(phone);
    var name = e.getAttribute('class');
    var btn = document.getElementById('sb-login');
    if (isNum) {
        document.getElementById(name).classList.remove('hidden');
        document.getElementById(name).innerText = 'Phone number does not contain characters';
        btn.setAttribute('style', 'background-color: #ddd');
        btn.disabled = true;
    } else {
        document.getElementById(name).classList.add('hidden');
        btn.setAttribute('style', 'background-color: #FE980F');
        btn.disabled = false;

    }

    if(phone.length > 10) {
        btn.setAttribute('style', 'background-color: #ddd');
        document.getElementById(name).classList.remove('hidden');
        document.getElementById(name).innerText = 'Phone number must not exceed 10 digits';
        btn.disabled = true;

    }
}

function check(e)
{
    var btn = document.getElementById('sb-sign-up');
    if(e.value.indexOf(' ') >= 0) {
        if(e.getAttribute('name') == 'txt-name') {
            btn.setAttribute('style', 'background-color: #ddd');
            btn.disabled = true;
            document.getElementById('name_error').classList.remove('hidden');
        } else {
            btn.setAttribute('style', 'background-color: #ddd');
            btn.disabled = true;
            document.getElementById('password_error').classList.remove('hidden');
            document.getElementById('password_error').innerText = 'Passwords do not contain spaces';
        }
    } else {
        if(e.getAttribute('name') == 'txt-name') {
            btn.setAttribute('style', 'background-color: #FE980F');
            btn.disabled = false;
            document.getElementById('name_error').classList.add('hidden');
        } else {
            btn.disabled = false;
            btn.setAttribute('style', 'background-color: #FE980F');
            document.getElementById('password_error').classList.add('hidden');
        
            if (e.value.length < 4 && e.value.length != 0 ) {
                btn.setAttribute('style', 'background-color: #ddd');
                btn.disabled = true;
                document.getElementById('password_error').classList.remove('hidden');
                document.getElementById('password_error').innerText = 'Password must be more than 4 characters';
            } else {
                btn.disabled = false;
                btn.setAttribute('style', 'background-color: #FE980F');
                document.getElementById('password_error').classList.add('hidden');
            
            }
           }
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