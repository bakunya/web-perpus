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

const getOptions = (arrayData) => {
  const opt = {
    no: arrayData[0].trim(),
    nama: arrayData[1].trim(),
    telp: arrayData[2].trim(),
    email: arrayData[3].trim(),
    gender: arrayData[4].trim(),
    alamat: arrayData[5].trim(),
  }

  return opt
}

const getHtmlDelete = (id) => {
  return `
  <div class="content-delete">
    <h1>Warning!!</h1>
    
    <p>Are You Sure To Delete Permanent This Content?</p>
    <p style="margin: 10px;">Press ENTER to continue...</p>
    <div class="action">
      <button class="no">No</button>
      <form method="post" action="/web-perpus/action/user/delete.php">
        <input type="text" value="${id}" name="id" style="display:none;" />
        <button type="submit" class="yes">Yes</button>
      </form>                      
    </div>
  </div>
`
}

const getHtmlUpdate = (target, opt = undefined) => {
  return `
  <div class="update-book">
    <h1>${target === "update" ? 'update users' : 'add users' }</h1>
    <div class="modal-update-content">
      <div class="form">
          <form method="post" action="${target === "update" ? '/web-perpus/action/user/update.php' : '/web-perpus/action/user/tambah.php' }">
            <label for="no">no anggota</label>
            <input type="text" placeholder="No Anggota" value="${opt?.no || ""}" name="no" id="no" />
            ${
              target === "update"
              ? `<input type="text" placeholder="No Anggota" value="${opt?.no || ""}" name="oldNo" id="no" style="display:none;" />`
              : ""
            }
            <label for="nama">nama</label>
            <input type="text" placeholder="Nama" value="${opt?.nama || ""}" name="nama" id="nama" />
            <label for="alamat">alamat</label>
            <input type="text" placeholder="Alamat" value="${opt?.alamat || ""}" name="alamat" id="alamat" />
            <label for="email">email</label>
            <input type="email" placeholder="Email" value="${opt?.email || ""}" name="email" id="email" />
            <label for="telp">telp</label>
            <input type="telp" placeholder="Telephone" value="${opt?.telp || ""}" name="telp" id="telp" />
            <p>jenis kelamin</p>
            <div class="jk">
              <input type="radio" id="male" name="gender" value="male" ${opt?.gender === "male" && "checked"} />
              <label for="male">Male</label><br />
              <input type="radio" id="female" name="gender" value="female" ${opt?.gender === "female" && "checked"} />
              <label for="female">Female</label>
            </div>
            <button type="submit" name="add_user">SEND</button>
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

function openSezamUpdate(target, data) {
  modalContainer.classList.remove("hidden");

  let opt;
  if(data) {
    const arrayData = data.split(",")
    opt = getOptions(arrayData)
  }
  console.log(opt);

  const htmlModal = target === "update" ? getHtmlUpdate(target, opt) : getHtmlUpdate(target)
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal  

  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}