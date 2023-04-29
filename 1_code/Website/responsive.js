//Toggles between regular and mobile navbars

function responsive() {
  var x = document.querySelector("nav");
  if (x.className === "") {
    x.className += " responsive";
  } else {
    x.className = "";
  }
}
