// Get the modal
var modal = document.getElementById('myModal');
var notModal = document.getElementsByClassName('notModal');

// Get the button that opens the modal
var btn = document.getElementsByClassName('btnDesk');
var btn2 = document.getElementsByClassName('btnMob');

// Get the <span> element that closes the modal
var closeBtn = document.getElementById('closeCtaBtn');

// When the user clicks the button, open the modal

for(i=0; i<btn.length; i++) {
  btn[i].onclick = function(event) {
    modal.style.visibility = "visible";
    modal.style.opacity = "1";
    for(i=0; i<notModal.length; i++) {
      notModal[i].style.filter = "blur(10px)";
    }
  }
}

for(i=0; i<btn2.length; i++) {
  btn2[i].onclick = function(event) {
    modal.style.visibility = "visible";
    modal.style.opacity = "1";
    for(i=0; i<notModal.length; i++) {
      notModal[i].style.filter = "blur(10px)";
    }
  }
}

// When the user clicks on <span> (x), close the modal
closeBtn.onclick = function() {
  modal.style.visibility = "hidden";
  modal.style.opacity = "0";
  for(i=0; i<notModal.length; i++) {
    notModal[i].style.filter = "none";
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.visibility = "hidden";
    modal.style.opacity = "0";
    for(i=0; i<notModal.length; i++) {
      notModal[i].style.filter = "none";
    }
  }
}
