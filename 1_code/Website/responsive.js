//Toggles between regular and mobile navbars

export default function responsive() {
    var x = document.querySelector("nav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
  }