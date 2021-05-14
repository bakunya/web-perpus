const btnNav = document.querySelector(".button-nav");
const nav = document.querySelector(".fixed-nav");
const modal = document.querySelector(`.modal-container-detail`)
const modalChild = document.querySelector(`.modal-detail`)

btnNav.addEventListener("click", () => {
  nav.classList.toggle("show")
  window.addEventListener("click", (e) => {
    if (e.target.getAttribute("class") !== "fixed-nav" && e.target.getAttribute("class") !== "button-nav") {
      nav.classList.remove("show")
    }
  });
})

const getOpt = (dataArray) => {
  return {
    kode: dataArray[0].trim(),
    ISBN: dataArray[1].trim(),
    title: dataArray[2].trim(),
    publisher: dataArray[3].trim(),
    publication: dataArray[4].trim(),
    bookNum: dataArray[5].trim(),
    image: `/web-perpus/uploads/buku/${dataArray[6].trim()}`,
  }
}

const getHtmlDetail = (opt) => {
  return `<h1>Detail</h1>
    <div class="modal-detail-content">
      <img src=${opt.image} alt=${opt.title} />
      <div class="info">
        <p>Kode: ${opt.kode}</p>
        <p>ISBN: ${opt.ISBN}</p>
        <p>title: ${opt.title}</p>
        <p>number of books: ${opt.bookNum}</p>
        <p>publisher: ${opt.publisher}</p>
        <p>publication year: ${opt.publication}</p>
      </div>
    </div>`
  }

const getHtmlBorrow = (opt) => {
  return `<h1>borrowing book</h1>
    <div class="modal-borrow-content">
      <img src=${opt.image} alt="Buku" />
      <form method="POST" action="/web-perpus/action/pinjam/tambah.php">
        <label for="book_id">title</label>
        <input type="text" id="book_id" placeholder="Book ID" required disabled class="book_id" value=${opt.title} >
        <input type="text" name="id" id="book_id" required value=${opt.kode} style="display:none;" >
        <label for="borrower">Peminjam ID</label>
        <select name="peminjam" id="borrower" class="input">
          ${
            anggotaArray.map(kode => {
              return `<option value="${kode}">${kode}</option>`
            })
          }
        </select>
        <label for="tenggat">Tenggat waktu (dalam hari).</label>
        <input type="number" name="tenggat" id="tenggat" placeholder="Dalam hari." required value="7">
        <label for="denda">denda (per 1 hari terlambat).</label>
        <input type="number" name="denda" id="denda" placeholder="Dalam hari." required value="1000">
        <label for="date">date</label>
        <input type="date" name="date" id="date" required>
        <button type="submit" name="submit">Save</button>
      </form>
    </div>`
}


function openSezam(params, target) {
  const dataArray = params.split(",")
  let opt = {
    kode: dataArray[0].trim(),
    image: `/web-perpus/uploads/buku/${dataArray[1].trim()}`,
    title: dataArray[2].trim(),
  }

  if (dataArray.length > 3) {
    opt = getOpt(dataArray)  
  }

  const htmlModal = target === "borrow" ? getHtmlBorrow(opt) : getHtmlDetail(opt)

  
  modal.classList.remove("hidden");
  
  setTimeout(() => {
    modalChild.innerHTML = htmlModal
    modalChild.classList.add("modal-child-show");
    target === "borrow" && (document.getElementById('date').valueAsDate = new Date());
  }, 10);
    

    windowClick(modal, modalChild, "modal-container-detail")
    windowPress(modal, modalChild)
}
