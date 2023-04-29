//Toggles between regular and mobile navbars

function responsive() {
  var x = document.querySelector("nav");
  if (x.className === "" || x.className === "logged-in" || x.className === "logged-out") {
    x.className += " responsive";
  } else {
    x.className = "";
  }
}

//toggle elements to display when logged in/out

addEventListener("DOMContentLoaded", () => {
  //grab logged in/out elements
  const loggedOutLinks = document.querySelectorAll(".logged-out");
  const loggedInLinks = document.querySelectorAll(".logged-in");

  //check if user is logged in
  if (document.cookie){
    loggedOutLinks.forEach((item) => (item.style.display = "none"));
    loggedInLinks.forEach((item) => (item.style.display = "block"));
  }
  //if user is not logged in
  else {
    loggedOutLinks.forEach((item) => (item.style.display = "block"));
    loggedInLinks.forEach((item) => (item.style.display = "none"));
  }

});




