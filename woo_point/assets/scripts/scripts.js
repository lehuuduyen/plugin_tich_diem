window.addEventListener("load", function() {
  /* Tabs */
  const tabs = document.querySelectorAll("ul.nav-tabs > li");
  for (i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event) {
    event.preventDefault();
    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector(".tab-pane.active").classList.remove("active");

    const clickedTab = event.currentTarget;
    const anchor = event.target;
    const activePaneID = anchor.getAttribute("href");
    
    clickedTab.classList.add("active");
    document.querySelector(activePaneID).classList.add("active");
  }

  /* Modal */
  let step = 1;

  const modalOverlay = document.getElementById('overlay');

  const modalAddBtn = document.getElementById('modal-add-btn');
  const modalEditBtn = document.getElementById('modal-edit-btn');
  const modalAdd = document.getElementById('modal-add');
  const modalClose = document.getElementById('modal-close');

  const modalNext = document.getElementById('modal-next');
  const modalPrev = document.getElementById('modal-prev');
  const modalUpdate = document.getElementById('modal-update');

  modalAddBtn.addEventListener("click", function() {
    openModal();
  });

  modalEditBtn.addEventListener("click", function() {
    openModal();
  });

  modalClose.addEventListener("click", function() {
    modalOverlay.classList.add('d-none');
    modalAdd.classList.add('d-none');
  });

  modalNext.addEventListener("click", function() {
    step++;
    changeModalContent();
    modalPrev.classList.remove('d-none');
    document.getElementById(`step-${step}`).classList.add('current');

    for (let i = step - 1; i > 0; i--) {
      document.getElementById(`step-${i}`).classList.add('active');
    }

    if (step === 4) {
      modalNext.classList.add('d-none');
      modalUpdate.classList.remove('d-none');
    }
  });

  modalPrev.addEventListener("click", function() {
    document.getElementById(`step-${step}`).classList.remove('current');
    step--;
    document.getElementById(`step-${step}`).classList.remove('active');

    if (step === 1) {
      modalPrev.classList.add('d-none');
    }

    if (step === 3) {
      modalNext.classList.remove('d-none');
      modalUpdate.classList.add('d-none');
    }

    changeModalContent();
  });

  function openModal() {
    step = 1;
    modalPrev.classList.add('d-none');
    modalUpdate.classList.add('d-none');
    modalOverlay.classList.remove('d-none');
    modalAdd.classList.remove('d-none');
    modalNext.classList.remove('d-none');
    
    for (let i = 1; i <= 4; i++) {
      document.getElementById(`step-${i}`).classList.remove('current');
      document.getElementById(`step-${i}`).classList.remove('active');
    }

    changeModalContent();
  }

  function changeModalContent() {
    for (let i = 1; i <= 4; i++) {
      if (i === step) {
        document.getElementById(`content-step-${i}`).classList.remove('d-none');
      } else {
        document.getElementById(`content-step-${i}`).classList.add('d-none');
      }
    }
  }
});
