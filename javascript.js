//Show & Hide Header
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (currentScrollPos > prevScrollpos && currentScrollPos > 100) {
    document.getElementById("header").style.top = "-18rem";
  } else {
    document.getElementById("header").style.top = "0";
  }
  prevScrollpos = currentScrollPos;
}

//Dropdown Usermenu
function usermenu() {
  var dropdownContent = document.getElementById("dropdownContent");
  var usermenuElement = document.getElementById("usermenu");
  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
  }
  // remove previous listener if it exists (prevents stacking)
  document.removeEventListener('click', hideOnClickOutside);
  // hide on outside click
  function hideOnClickOutside(event) {
    if (!usermenuElement.contains(event.target)) { // check if clicking outside usermenu
      dropdownContent.style.display = "none";
    }
  }
  document.addEventListener('click', hideOnClickOutside);
}
