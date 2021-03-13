const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendButton = form.querySelector("button");

sendButton.onclick = () => {
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "php/chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                if (data == "success") {
                    location.href = "users.php";
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    // Send form data from ajax to php
    let formData = new FormData(form);
    xhr.send(formData);
}