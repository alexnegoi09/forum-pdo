let user = document.querySelector('.logged-in');
let userLink = document.querySelector('.user-link');

if (user.innerText.includes('Administrator')) {
    userLink.classList.add('user-red');
} else if (userLink.innerText.includes('Moderator')) {
    userLink.classList.add('user-green');
} else {
    userLink.classList.add('user-black');
}