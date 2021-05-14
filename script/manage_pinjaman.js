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
  console.log(dataArray);
  const opt = {
    id: dataArray[0].trim(),
    kode_peminjam: dataArray[1].trim(),
    kode_buku: dataArray[2].trim(),
    tenggat: dataArray[3].trim(),
    denda: dataArray[4].trim(),
    date_start: dataArray[5].trim(),
    date_end: dataArray[6].trim(),
    lunas: dataArray[7].trim(),
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
      <form method="post" action="/web-perpus/action/pinjam/delete.php">
        <input type="text" value="${id}" name="id" style="display: none;" />
        <button type="submit" class="yes">Yes</button>
      </form>                      
    </div>
  </div>
`
}

const getHtmlUpdate = (opt = undefined) => {
  return `
  <div class="update-book">
    <h1>updating book</h1>
    <div class="modal-update-content">
      <div class="form">
          <form method="post" action='/web-perpus/action/pinjam/update.php'>
              <input type="text" value="${opt?.id || ""}" name="id" id="kode" required placeholder="Book Code" style="display:none;"/>
              <label for="peminjam">Kode Peminjam</label>
              <select name="peminjam" id="peminjam" class="input">
                ${
                  kodepeminjam.map((kode) => {
                    if (opt && kode === opt?.kode_peminjam) {
                      return `<option value="${kode}" selected>${kode}</option>`
                    }
                    return `<option value="${kode}">${kode}</option>`
                  })
                }
              </select>
              <label for="buku">Kode Buku</label>
              <select name="buku" id="buku" class="input">
                ${
                  kodebuku.map((kode) => {
                    if (opt && kode === opt?.kode_buku) {
                      return `<option value="${kode}" selected>${kode}</option>`
                    }
                    return `<option value="${kode}">${kode}</option>`
                  })
                }
              </select>
              <label for="tenggat">tenggat (dalam hari)</label>
              <input type="number" value="${opt?.tenggat || ""}" name="tenggat" id="tenggat" required placeholder="tenggat (dalam hari)"/>
              <label for="denda">Denda per hari terlambat</label>
              <input type="text" value="${opt?.denda || ""}" name="denda" id="denda" required placeholder="Denda per hari terlambat"/>
              <label for="date">Mulai pinjam</label>
              <input type="date" value="${opt?.date_start || ""}" name="start" id="date" required placeholder="Mulai pinjam"/>
              <label for="akhir">Akhir pinjam</label>
              <input type="date" value="${opt?.date_end || ""}" name="akhir" id="akhir" required placeholder="Akhir pinjam"/>
              <button name="submit type="submit">SEND</button>
        </form>
      </div>
    </div>
  </div>
  `
}


function openSezamDelete(id) {
  modalContainer.classList.remove("hidden");
  const htmlModal = getHtmlDelete(id.trim())
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal
  
  autoSubmitEnter()
  closeButtonNo(modalContainer, modalContent)
  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}

function openSezamUpdate(data = null) {
  modalContainer.classList.remove("hidden");

  let opt;
  if(data) {
    const dataArray = data.split(",")
    opt = getOptions(dataArray)
  }

  const htmlModal = getHtmlUpdate(opt)
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal  

  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}