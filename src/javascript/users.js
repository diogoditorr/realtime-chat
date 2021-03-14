const searchBar = document.querySelector(".users .search input");
const searchButton = document.querySelector(".users .search button");
const usersList = document.querySelector(".users .users-list");

searchButton.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchButton.classList.toggle("active");
    searchBar.value = "";
}

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;

    if (searchTerm != "") {
        let xhr = new XMLHttpRequest(); // Creating XML object
        xhr.open("POST", "php/search.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    usersList.innerHTML = data;
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("searchTerm=" + searchTerm);
    }
}

setInterval(() => {
    if (searchBar.value === "") {
        let xhr = new XMLHttpRequest(); // Creating XML object
        xhr.open("GET", "php/users.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    usersList.innerHTML = data;
                }
            }
        }
        xhr.send();
    }
}, 1500);