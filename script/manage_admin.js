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

const getHtmlDelete = (id) => {
  return `
  <div class="content-delete">
    <h1>Warning!!</h1>
    
    <p>Are You Sure To Delete Permanent This Content?</p>
    <p style="margin: 10px;">Press ENTER to continue...</p>
    <div class="action">
      <button class="no">No</button>
      <form method="post" action="/web-perpus/action/admin/delete.php">
        <input type="text" value="${id}" name="username" style="display:none;" />
        <button type="submit" class="yes">Yes</button>
      </form>                      
    </div>
  </div>
`
}

const oldPassword = `
<label for="nama">Old Password</label>
<input type="password" placeholder="Old Password" name="oldPassword" id="nama" />`

const oldUsername = (username = "") => `
<input type="text" placeholder="Old Username" value="${username}" name="oldUsername" id="kode" style="display:none;" />`

const getHtmlUpdate = (target, username = undefined, update = undefined) => {
  return `
  <div class="update-book">
    <h1>${target === "update" ? 'update penulis' : 'add penulis' }</h1>
    <div class="modal-update-content">
      <div class="form">
        ${update ? '<p style="padding-top: 10px; color: red;">Kolom password dan old password tidak perlu di isi jika hanya update username.</p>' : ""}
        <form method="post" action="${target === "update" ? '/web-perpus/action/admin/update.php' : '/web-perpus/action/admin/tambah.php' }">
            <label for="kode">username</label>
            <input type="text" placeholder="username" value="${username || ""}" name="username" id="kode" required />
            ${update ? oldUsername(username) : ""}
            <label for="nama">password</label>
            <input type="password" placeholder="password" name="password" id="nama" />
            ${update ? oldPassword : ""}
            <button type="submit">SEND</button>
        </form>
      </div>
    </div>
  </div>
  `
}

function openSezamDelete(id) {
  modalContainer.classList.remove("hidden");
  const htmlModal = getHtmlDelete(id)
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal
  

  autoSubmitEnter()
  closeButtonNo(modalContainer, modalContent)
  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}

function openSezamUpdate(target, username) {
  modalContainer.classList.remove("hidden");

  const htmlModal = target === "update" ? getHtmlUpdate(target, username, true) : getHtmlUpdate(target)
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal  

  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}