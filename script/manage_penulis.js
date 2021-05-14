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

const getOptions = (dataArray) => {
  const opt = {
    kode: dataArray[0].trim(),
    nama: dataArray[1].trim(),
    alamat: dataArray[2].trim(),
    telp: dataArray[3].trim()
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
      <form method="post" action="/web-perpus/action/penulis/delete.php">
        <input type="text" value="${id}" name="kode" style="display:none;" />
        <button type="submit" class="yes">Yes</button>
      </form>                      
    </div>
  </div>
`
}

const getHtmlUpdate = (target, opt = undefined) => {
  return `
  <div class="update-book">
    <h1>${target === "update" ? 'update penulis' : 'add penulis' }</h1>
    <div class="modal-update-content">
      <div class="form">
          <form method="post" action="${target === "update" ? '/web-perpus/action/penulis/update.php' : '/web-perpus/action/penulis/tambah.php' }">
              <label for="kode">Kode Penulis</label>
              <input type="text" placeholder="Kode Penulis" value="${opt?.kode || ""}" name="kode" id="kode" required />
              ${
                target === "update" 
                ? `<input type="text"value="${opt?.kode || ""}" name="oldKode" id="kode" required style="display:none;" />`
                : ""
              }
              <label for="nama">nama</label>
              <input type="text" placeholder="Nama" value="${opt?.nama || ""}" name="nama" id="nama" required />
              <label for="alamat">alamat</label>
              <input type="text" placeholder="Alamat" value="${opt?.alamat || ""}" name="alamat" id="alamat" />
              <label for="telp">telp</label>
              <input type="tel" placeholder="Telp" value="${opt?.telp || ""}" name="telp" id="telp" />
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

function openSezamUpdate(target, data) {
  modalContainer.classList.remove("hidden");

  let opt;
  if(data) {
    const dataArray = data.split(',')
    opt = getOptions(dataArray)
  }

  const htmlModal = target === "update" ? getHtmlUpdate(target, opt) : getHtmlUpdate(target)
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal  

  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}