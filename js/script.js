document.addEventListener("DOMContentLoaded", function() {

    let userName = document.querySelector("#userName");
    let userOptions = document.querySelector(".userOptions");


    userName.addEventListener("click", () => userOptions.classList.toggle("ocultar"));
});