if (document.querySelector('.written-by') !== 'null') {

    let users = document.querySelectorAll('.written-by');

    users.forEach((user) => {
        if (user.innerText.includes('Administrator')) {
            user.childNodes[1].classList.add('user-red');
        } else if (user.innerText.includes('Moderator')) {
            user.childNodes[1].classList.add('user-green');
        } else {
            user.childNodes[2].classList.add('user-black');
        }   
    });
}