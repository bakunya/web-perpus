const wrap = document.querySelectorAll(".img")
const imgInWrap = document.querySelectorAll(".img img")
const img = document.querySelector("#modal-img")
const container = document.querySelector(".modal-container")
const child = document.querySelector(".modal-gallery")
const next = document.querySelector("#next");
const prev = document.querySelector("#prev");
const prevDiv = document.querySelector(".prev");
const nextDiv = document.querySelector(".next");

wrap.forEach((elm, i) => {
    elm.addEventListener("click", e => {
        console.log(e)
        img.src = e.target.src
        container.classList.remove("hidden")
        setTimeout(() => {
            child.classList.add("show-child")
        }, 20);

        const src = []
        imgInWrap.forEach(s => src.push(s.src))
        const last = src.length
        let count = i

        console.log(i);

        prev.addEventListener("click", () => {
            if(count >= 1) {
                -- count
                img.src = src[count]
            }
        })


        next.addEventListener("click", () => {
            if(count < last - 1){
                count ++
                img.src = src[count]
            }
        })

        prevDiv.addEventListener("click", () => {
            if(count >= 1) {
                -- count
                img.src = src[count]
            }
        })

        nextDiv.addEventListener("click", () => {
            if(count < last - 1){
                count ++
                img.src = src[count]
            }
        })

        window.addEventListener("click", e => {
            if (e.target.getAttribute("class") === "modal-container") {
                setTimeout(() => {
                    img.src = e.target.src
                    container.classList.add("hidden")
                }, 250);
                child.classList.remove("show-child")
            }
        })
    })
})