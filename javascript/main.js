var index;
var Modal;

function display(i) {
    let modal = document.getElementById("modal-" + i);
    let modal_close = document.getElementById("close-" + i);
    Modal = modal;
    index = i;
    modal_close.addEventListener('click', closeModal);
    window.addEventListener('click', clickOutside);
    modal.style.display = "block";


}

function clickOutside(e) {

    if (e.target == Modal) {
        Modal.style.display = "none";
    }

}

function closeModal() {


    let modal = document.getElementById("modal-" + index);

    modal.style.display = "none";

}

function openSlidMenu() {

    document.getElementById("left-sidebar").style.width = "250px";
    document.getElementById("container").style.paddingLeft = "250px";


}

function closeSlidMenu() {

    document.getElementById("left-sidebar").style.width = "0";
    document.getElementById("container").style.paddingLeft = "0";

}
var i =1;
function openAndCloseCart() {
        i++;
    if (i%2==0) {
        document.getElementById('purchase').style.height = 'auto';
        document.getElementById('openCart-span').className='fas fa-sort-up';
    }else {
        document.getElementById('purchase').style.height = '0';
        document.getElementById('openCart-span').className='fas fa-sort-down';
    }

}