function initCalendar() {
  var calendarEl = document.getElementById("calendar");

  calendarEl.innerHTML = "";

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
  });

  calendar.render();

  window.modalCalendar = calendar;
}

document.addEventListener("shown.bs.modal", function () {
  setTimeout(initCalendar, 0);
});

events: "../../backend/sales-management/inquiryDates.php";
