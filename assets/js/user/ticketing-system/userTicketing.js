const textarea = document.getElementById("ticket_content");
const maxRows = 20;

// Calculate max height based on line height and max rows
const lineHeight = parseFloat(window.getComputedStyle(textarea).lineHeight);
const maxHeight = lineHeight * maxRows;

textarea.addEventListener("input", function () {
    this.style.height = "auto"; // Reset height to shrink if necessary

    // Set height to scrollHeight but limit it to maxHeight
    if (this.scrollHeight > maxHeight) {
        this.style.height = maxHeight + "px";
        this.style.overflowY = "scroll"; // Show scrollbar if max height reached
    } else {
        this.style.height = this.scrollHeight + "px";
        this.style.overflowY = "hidden"; // Hide scrollbar within limit
    }
});


// populate from similar tickets 

document.addEventListener('DOMContentLoaded', function () {
    const ticketCategoryInput = document.getElementById('ticket_category');
    const ticketSubjectInput = document.getElementById('ticket_subject');
    const ticketContentInput = document.getElementById('ticket_content');
    const similarTicketDiv = document.querySelector('.similar-ticket');

    // Listen for input on the ticket subject field
    ticketSubjectInput.addEventListener('input', function () {
        const subject = ticketSubjectInput.value.trim();

        if (subject.length > 2) {
            fetch(`../../../backend/user/ticketing-system/similarticket.php?category=${ticketCategoryInput.value.trim() + '&subject=' + encodeURIComponent(subject)}`)
                .then(response => response.json())
                .then(data => {
                    similarTicketDiv.innerHTML = ''; // Clear previous results

                    if (data.length > 0) {
                        similarTicketDiv.classList.remove('hidden');

                        data.forEach(ticket => {
                            const ticketItem = document.createElement('div');
                            ticketItem.textContent = ticket.ticket_subject + " | " + ticket.requestor_name;
                            ticketItem.className = 'ticket-item';
                            similarTicketDiv.appendChild(ticketItem);

                            // Make ticket item clickable to populate fields
                            ticketItem.addEventListener('click', function () {
                                ticketCategoryInput.value = ticket.ticket_type;
                                ticketSubjectInput.value = ticket.ticket_subject;
                                ticketContentInput.value = ticket.ticket_description;
                                similarTicketDiv.classList.add('hidden'); // Hide suggestions after selection
                            });
                        });
                    } else {
                        similarTicketDiv.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error fetching similar tickets:', error));
        } else {
            similarTicketDiv.classList.add('hidden'); // Hide if input is cleared or too short
        }
    });
});