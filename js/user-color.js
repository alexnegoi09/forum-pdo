const links = document.querySelector('.links');

if (!links.innerText.includes('Guest')) {
    let user = document.querySelector('.logged-in');

    let userLink = document.querySelector('.user-link');

    if (user.innerText.includes('Administrator')) {
    userLink.classList.add('user-red');
    } else if (user.innerText.includes('Moderator')) {
        userLink.classList.add('user-green');
    } else {
        userLink.classList.add('user-black');
    }
}