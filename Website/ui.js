const loggedOutLinks = document.querySelectorAll(".logged-out");
const loggedInLinks = document.querySelectorAll(".logged-in");

let user = false;

const setupUI = (user) => {
    //toggle UI elements
    if(user) { //logged in
        loggedOutLinks.forEach((item) => (item.style.display = "none"));
        loggedInLinks.forEach((item) => (item.style.display = "block"));
    } else { //logged out
        loggedOutLinks.forEach((item) => (item.style.display = "block"));
        loggedInLinks.forEach((item) => (item.style.display = "none"));
    }
};