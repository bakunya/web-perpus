const buttonsUpdate = document.querySelectorAll("button.update");
const btnClose = document.querySelector(".modal button");
const btnNav = document.querySelector(".button-nav");
const nav = document.querySelector(".fixed-nav");
const deleteButtons = document.querySelectorAll("button.delete")
const buttonAdd = document.querySelector(".button-add")
const modalContainer = document.querySelector(`.modal-container`)
const modalContent = document.querySelector(`.modal-content`)


btnNav.addEventListener("click", () => {
  nav.classList.toggle("show")
  window.addEventListener("click", (e) => {
    if (e.target.getAttribute("class") !== "fixed-nav" && e.target.getAttribute("class") !== "button-nav") {
      nav.classList.remove("show")
    }
  });
})
const getHtmlDelete = (id, image) => {
  return `
  <div class="content-delete">
    <h1>Warning!!</h1>
    
    <p>Are You Sure To Delete Permanent This Content?</p>
    <p style="margin: 10px;">Press ENTER to continue...</p>
    <div class="action">
      <button class="no">No</button>
      <form method="post" action="/web-perpus/action/gallery/delete.php">
        <input type="text" value="${id}" name="id" style="display: none;" />
        <input type="text" value="${image}" name="image" style="display: none;" />
        <button type="submit" class="yes">Yes</button>
      </form>                      
    </div>
  </div>
`
}

const getHtmlAdd = () => {
  return `
  <div class="update-book">
    <h1>updating book</h1>
    <div class="modal-update-content">
      <div class="img">
          <img src="/web-perpus/img/preview.png" alt="preview" class="img_update"/>
      </div>
      <div class="form">
          <form method="post" action="/web-perpus/action/gallery/tambah.php" enctype="multipart/form-data">
              <input type="file" name="image" id="image" accept="image/*" class="input_file" />
              <button name="submit type="submit">SEND</button>
          </form>
      </div>
    </div>
  </div>
  `
}


function openSezamDelete(id, image) {
  modalContainer.classList.remove("hidden");
  const htmlModal = getHtmlDelete(id.trim(), image.trim())
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal
  
  autoSubmitEnter()
  closeButtonNo(modalContainer, modalContent)
  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent)
}

function openSezamAdd() {
  modalContainer.classList.remove("hidden");

  const htmlModal = getHtmlAdd()
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal  

  const img = document.querySelector(".input_file")
  const imgUpdate = document.querySelector(".img_update")
  const originalSrc = imgUpdate.src
  
  img.addEventListener("change", (e) => {
    readFile(e.target.files[0], imgUpdate)
    e.target.files.length ? img.classList.add("image-active") : img.classList.remove("image-active")
    !e.target.files.length && (imgUpdate.src = originalSrc)
  })

  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}