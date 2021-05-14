const readFile = (file = undefined, target) => {
    if (file !== undefined) {
        const reader = new FileReader()
        reader.addEventListener("load", e => {
            target.src = e.target.result
        })

        reader.readAsDataURL(file)
    }
}

const windowClick = (container, child, classContainer) => window.addEventListener("click", e => {
  if(e.target.getAttribute("class") === classContainer){
    setTimeout(() => {
      container.classList.add("hidden")
    }, 250);
    child.classList.remove("modal-child-show")
  }
})

const windowPress = (container, child) => window.addEventListener("keydown", e => {
  if(e.key === "Escape" || e.keyCode == 27) {
      setTimeout(() => {
        container.classList.add("hidden")
      }, 250);
      child.classList.remove("modal-child-show")
  }
})

const autoSubmitEnter = () => window.addEventListener("keydown", e => {
  if (e.key === "Enter") {
    document.querySelector("form").submit()
  }
})

const closeButtonNo = (container, child) => document.querySelector(".no").addEventListener("click", e => {
  setTimeout(() => {
    container.classList.add("hidden")
  }, 250);
  child.classList.remove("modal-child-show")
})