const form = document.querySelector(".signup form");
const continueButton = form.querySelector(".button input");

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
}

continueButton.onclick = () => {
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
            }
        }
    }
    // Send form data from ajax to php
    let formData = new FormData(form);
    xhr.send(formData);
}