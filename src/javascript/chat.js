const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendButton = form.querySelector("button");
const chatBox = document.querySelector('.chat-box');

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
}

sendButton.onclick = () => {
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = "";
                chatBox.classList.add("scroll");
            }
        }
    }
    // Send form data from ajax to php
    let formData = new FormData(form);
    xhr.send(formData);
}

// chatBox.onmouseenter = () => {
//     chatBox.classList.add("active");
// }

// chatBox.onmouseleave = () => {
//     chatBox.classList.remove("active");
// }

setInterval(() => {
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (chatBox.classList.contains("scroll")) {
                    scrollToBottom();
                    chatBox.classList.remove("scroll");
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}, 1500);

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}