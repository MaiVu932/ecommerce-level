function validateName(e)
{
    if(e.value.indexOf(' ') >= 0) {
        document.getElementById('name').classList.remove('hidden');
        document.getElementById('sb').disabled = true;
    } else {
        document.getElementById('sb').disabled = false;
       document.getElementById('name').classList.add('hidden');
    }
}

function validatePassword(e)
{
    if(e.value.indexOf(' ') >= 0) {
        document.getElementById('sb').disabled = true;
        document.getElementById('password').classList.remove('hidden');
        document.getElementById('password').innerText = 'Password do not contain spaces';
    } else {
        document.getElementById('sb').disabled = false;
       document.getElementById('password').classList.add('hidden');
       if (e.value.length < 4) {
            document.getElementById('sb').disabled = true;
            document.getElementById('password').classList.remove('hidden');
            document.getElementById('password').innerText = 'Password must be longer than 4 characters';
        } else {
            document.getElementById('sb').disabled = false;
            document.getElementById('password').classList.add('hidden');
        }
    }
   
}

function validatePhone(e) 
{
    var phone = e.value.trim();
    var isNum = isNaN(phone);
    var name = e.getAttribute('class');
    
    if (isNum) {
        document.getElementById('sb').disabled = true;
        document.getElementById(name).classList.remove('hidden');
        document.getElementById(name).innerText = 'Phone number does not contain characters';
    } else {
        document.getElementById('sb').disabled = false;
        document.getElementById(name).classList.add('hidden');

    }

    if(phone.length > 10) {
        document.getElementById('sb').disabled = true;
        document.getElementById(name).classList.remove('hidden');
        document.getElementById(name).innerText = 'Phone number must not exceed 10 digits';
    }
}

function hideShow(e)
{
    let pw = document.getElementById('pwi');
    if(pw.getAttribute('type') == 'password') {
        pw.setAttribute('type', 'text');
        document.getElementById('pw').innerText = 'Hide password';
    } else {
        pw.setAttribute('type', 'password');
        document.getElementById('pw').innerText = 'Show password';
    }
}