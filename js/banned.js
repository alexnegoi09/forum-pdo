if (document.body.innerText.includes('Written by:')) {
    const users = document.querySelectorAll('.written-by');
    
    users.forEach((user) => {
        if (user.innerText.includes('Banned')) {
            user.childNodes[1].classList.add('banned');
        }
    });
}