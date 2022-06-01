let dateS = document.getElementById('dateSearch');

dateS.addEventListener('focus', function() {
    dateS.setAttribute('type', 'date');
});

dateS.addEventListener('blur', function() {
    if(!dateS.value) { 
        dateS.setAttribute('type', 'text');
        dateS.setAttribute('placeholder', 'Thời gian tạo shop')
    }
});
