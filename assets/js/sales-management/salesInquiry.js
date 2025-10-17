// $(document).ready(function () {
//     const currentDate = new Date();
//     const currentYear = currentDate.getFullYear();
//     const currentMonth = currentDate.getMonth() + 1;
//     $.ajax({
//         type: "GET",
//         url: "../../backend/sales-management/getInquiriesYear.php",
//         success: function (response) {
//             if (response.status === 'internal-error') {
//                 Swal.fire({
//                     title: 'Error! ',
//                     text: `${response.message}`,
//                     icon: 'error',
//                     confirmButtonColor: 'var(--bs-danger)'
//                 });
//             } else if (response.status === 'success') {
//                 const years = response.data;
//                 $("#inquiryYear").empty().append(`<option value="">All</option>`);
//                 years.forEach(year => {
//                     $("#inquiryYear").append(`<option value="${year.inquiry_year}" ${year.inquiry_year === currentYear ? "selected" : ""}>${year.inquiry_year}</option> `);
//                 });
//             }
//         }
//     });
//     const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

//     $("#inquiryMonth").empty().append(`<option value="">All</option>`).append(months.map((month, index) => `<option value="${index + 1}">${month}</option>`));
//     $("#inquiryMonth").val(currentMonth);
// });