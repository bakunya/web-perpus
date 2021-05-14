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
    kodeBuku: dataArray[0].trim(),
    isbn: dataArray[1].trim(),
    judul: dataArray[2].trim(),
    jumlah: dataArray[3].trim(),
    penerbit: dataArray[4].trim(),
    tahun: dataArray[5].trim(),
    entry: dataArray[6].trim(),
    pengarang: dataArray[7].trim(),
    img: dataArray[8].trim(),
    stock: dataArray[9].trim(),
  }

  return opt
}

const getHtmlDelete = (id, image) => {
  return `
  <div class="content-delete">
    <h1>Warning!!</h1>
    
    <p>Are You Sure To Delete Permanent This Content?</p>
    <p style="margin: 10px;">Press ENTER to continue...</p>
    <div class="action">
      <button class="no">No</button>
      <form method="post" action="/web-perpus/action/buku/delete.php">
        <input type="text" value="${id}" name="id" style="display: none;" />
        <input type="text" value="${image}" name="image" style="display: none;" />
        <button type="submit" class="yes">Yes</button>
      </form>                      
    </div>
  </div>
`
}

const getHtmlUpdate = (target, opt = undefined) => {
  return `
  <div class="update-book">
    <h1>updating book</h1>
    <div class="modal-update-content">
      <div class="img">
          <img src=${opt ? "/web-perpus/uploads/buku/" + opt?.img : "/web-perpus/img/preview.png"} alt=${opt?.imgAlt || "preview"} class="img_update"/>
      </div>
      <div class="form">
          <form method="post" action="${target === "update" ? '/web-perpus/action/buku/update.php' : '/web-perpus/action/buku/tambah.php'}" enctype="multipart/form-data">
              <label for="kode">Kode Buku</label>
              <input type="text" value="${opt?.kodeBuku || ""}" name="kode_buku" id="kode" required placeholder="Book Code"/>
              <label for="isbn">ISBN</label>
              <input type="text" value="${opt?.isbn || ""}" name="isbn" id="isbn" required placeholder="ISBN"/>
              <label for="judul">Judul</label>
              <input type="text" value="${opt?.judul || ""}" name="judul" id="judul" required placeholder="Title"/>
              <label for="jumlah">Jumlah Buku</label>
              <input type="number" value="${opt?.jumlah || ""}" name="jumlah" id="jumlah" required placeholder="Many Of Book"/>
              ${
                target === "update" 
                ?
                `<label for="tidak_dipinjam">tidak di pinjam</label>
                <input type="number" value="${opt?.stock || ""}" name="tidak_dipinjam" id="tidak_dipinjam" required placeholder="tidak_dipinjam"/>
                <input type="number" value="${opt?.kodeBuku || ""}" name="oldKode" id="tidak_dipinjam" required placeholder="tidak_dipinjam" style="display:none;"/>`
                :
                ""
              }
              <label for="penerbit">Nama Penerbit</label>
              <input type="text" value="${opt?.penerbit || ""}" name="penerbit" id="penerbit" required placeholder="Publisher"/>
              <label for="tahun">Tahun Terbit</label>
              <input type="number" value="${opt?.tahun || ""}" name="tahun" id="tahun" required placeholder="Year of Release"/>
              <label for="entry">Entry Date</label>
              <input type="date" value="${opt?.entry || ""}" name="entry" id="entry" required/>
              <label for="image">Image</label>
              <input type="file" name="image" id="image" accept="image/*" class="input_file" />
              <input type="text" name="oldImage" id="oldImage" style="display:none;" value="${opt?.img || ""}" />
              <label for="penulis">Kode Penulis</label>
              <select name="penulis" id="penulis" class="input">
                ${
                  penulisKode.map(({kode, nama}) => {
                    if (opt && kode === opt?.pengarang) {
                      return `<option value="${kode}" selected>${nama}</option>`
                    }
                    return `<option value="${kode}">${nama}</option>`
                  })
                }
              </select>
              <button name="submit type="submit">SEND</button>
        </form>
      </div>
    </div>
  </div>
  `
}


function openSezamDelete(params) {
  modalContainer.classList.remove("hidden");
  const [id, image] = params.split(",")
  const htmlModal = getHtmlDelete(id.trim(), image.trim())
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
  }, 10);
  
  modalContent.innerHTML = htmlModal
  
  autoSubmitEnter()
  closeButtonNo(modalContainer, modalContent)
  windowClick(modalContainer, modalContent, "modal-container")
  windowPress(modalContainer, modalContent,)
}

function openSezamUpdate(target, data = null) {
  modalContainer.classList.remove("hidden");

  let opt;
  if(data) {
    const dataArray = data.split(",")
    opt = getOptions(dataArray)
  }

  const htmlModal = target === "update" ? getHtmlUpdate(target, opt) : getHtmlUpdate(target)
  
  setTimeout(() => {
    modalContent.classList.add("modal-child-show");
    if (target === "add") document.getElementById('entry').valueAsDate = new Date();
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