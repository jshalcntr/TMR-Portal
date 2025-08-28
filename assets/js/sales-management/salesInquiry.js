const fetchInquiriesByProspectCount = () => {
    $.ajax({
        type: "GET",
        url: "../../backend/sales-management/getInquiriesByProspectCount.php",
        success: function (response) {
            if (response.status === "internal-error") {
                Swal.fire({
                    title: 'Error!',
                    text: `${response.message}`,
                    icon: 'error',
                    confirmButtonColor: 'var(--bs-danger)'
                })
            } else if (response.status === "success") {
                let hotCount = 0;
                let warmCount = 0;
                let coldCount = 0;
                let lostCount = 0;

                response.data.forEach(item => {
                    switch (item.prospect_type) {
                        case "Hot":
                            hotCount = item.count;
                            break;
                        case "Warm":
                            warmCount = item.count;
                            break;
                        case "Cold":
                            coldCount = item.count;
                            break;
                        case "Lost":
                            lostCount = item.count;
                            break;
                    }
                })

                // console.log(`
                //     Hot: ${hotCount}
                //     Warm: ${warmCount}
                //     Cold: ${coldCount}
                //     Lost: ${lostCount}
                //     `);

                $("#prospectCountHot").text(hotCount);
                $("#prospectCountWarm").text(warmCount);
                $("#prospectCountCold").text(coldCount);
                $("#prospectCountLost").text(lostCount);
            }
        }
    });
}
$(document).ready(function () {
    fetchInquiriesByProspectCount();

    setInterval(() => {
        fetchInquiriesByProspectCount();
    }, 10000);
});