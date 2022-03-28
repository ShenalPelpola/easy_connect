let sidenav = document.querySelector(".sidenav");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");
let logo = document.querySelector("#logo-image");

closeBtn.addEventListener("click", () => {
    sidenav.classList.toggle("open");
    menuBtnChange();
});

// following are the code to change sidenav button(optional)
function menuBtnChange() {
    if (sidenav.classList.contains("open")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        logo.style.display = "block";
    } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        logo.style.display = "none";
    }
}