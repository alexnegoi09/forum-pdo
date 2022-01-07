const backBtn = document.querySelector('.back');

backBtn.addEventListener('click', goBack);

function goBack() {
    history.back();
}