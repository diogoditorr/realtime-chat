const form = document.querySelector(".typing-area");
const user_id = form.querySelector('input[name="outgoing_user_id"]').value;
const inputField = form.querySelector(".input-field");
const sendButton = form.querySelector("button");
const chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
};

// sendButton.onclick = () => {
//     let xhr = new XMLHttpRequest(); // Creating XML object
//     xhr.open("POST", "php/insert-chat.php", true);
//     xhr.onload = () => {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 inputField.value = "";
//                 chatBox.classList.add("scroll");
//             }
//         }
//     };
//     // Send form data from ajax to php
//     let formData = new FormData(form);
//     xhr.send(formData);
// };

sendButton.onclick = () => {
    const data = new FormData(form);
    const dataObject = Object.fromEntries(data.entries())

    fetch('php/insert-chat.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json;charset=utf-8"
        },
        body: JSON.stringify(dataObject)
    })
    .then(response => {
        if (response.status === 200) {
            inputField.value = "";
            chatBox.classList.add("scroll");
        }
    })
};

// chatBox.onmouseenter = () => {
//     chatBox.classList.add("active");
// }

// chatBox.onmouseleave = () => {
//     chatBox.classList.remove("active");
// }

function fillBodyChat() {
    if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
            let data = JSON.parse(this.response);

            chatBox.innerHTML = data
                .map((message) => {
                    message;
                    if (message.outgoing_user_id === user_id) {
                        return `
                        <div class="chat outgoing">
                            <div class="details">
                                <p>${message.msg}</p>
                            </div>
                        </div>
                    `;
                    } else {
                        return `
                        <div class="chat incoming">
                            <img src="php/images/${message.image}" alt="">
                            <div class="details">
                                <p>${message.msg}</p>
                            </div>
                        </div>
                    `;
                    }
                })
                .join("");

            if (chatBox.classList.contains("scroll")) {
                scrollToBottom();
                chatBox.classList.remove("scroll");
            }
        }
    }
}

setInterval(() => {
    let xhr = new XMLHttpRequest(); // Creating XML object
    let formData = new FormData(form);

    xhr.onload = fillBodyChat;
    xhr.open("POST", "php/get-chat.php", true);
    xhr.send(formData);
}, 3000);

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}
