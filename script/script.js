document.querySelectorAll(".img").forEach(elm => {
    elm.addEventListener("click", () => {
        window.location.replace("http://localhost/web-perpus/gallery.php")
    })
})