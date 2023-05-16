const uploadEventBtn = document.getElementById("upload-event-btn");
const eventFormPopup = document.getElementById("event-form-popup");
const closeEventBtn = document.getElementById("close-event-btn");

uploadEventBtn.addEventListener("click", () => {
  eventFormPopup.classList.add("show");
});

closeEventBtn.addEventListener("click", () => {
  eventFormPopup.classList.remove("show");
});

function closePopup() {

const uploadEventBtn = document.getElementById("upload-event-btn");
const eventFormPopup = document.getElementById("event-form-popup");
const closeEventBtn = document.getElementById("close-event-btn");

uploadEventBtn.addEventListener("click", () => {
  eventFormPopup.classList.add("show");
});

closeEventBtn.addEventListener("click", () => {
  eventFormPopup.classList.remove("show");
});

function closePopup() {
  eventFormPopup.style.display = "none";
}
}
