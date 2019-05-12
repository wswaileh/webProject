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