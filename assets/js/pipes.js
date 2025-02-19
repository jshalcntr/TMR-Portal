function convertToDate(date) {
    if (date === "0000-00-00" || date === null) {
        return "0000-00-00";
    } else {
        const parsedDate = new Date(date);
        return parsedDate.toISOString().split("T")[0];
    }
}

function convertToReadableDate(date) {
    if (date === "0000-00-00" || date === null) {
        return "No Date Recorded Yet";
    } else {
        const options = { year: "numeric", month: "short", day: "numeric" };
        const parsedDate = new Date(date);
        return parsedDate.toLocaleDateString("en-US", options);
    }
}

// function convertToReadableDateTime(date) {
//     if (date === "0000-00-00" || date === null) {
//         return "No Date Recorded Yet";
//     } else {
//         const options = { year: "numeric", month: "short", day: "numeric", hour: "numeric", minute: "numeric", hour12: true };
//         const parsedDate = new Date(date);
//         return parsedDate.toLocaleString("en-US", options);
//     }
// }

function convertFromReadableDate(date) {
    const [month, day, year] = date.split(" ");
    const formattedDate = new Date(`${month} ${day.replace(",", "")} ${year}`);
    return formattedDate.toISOString().split("T")[0];
}

function convertToPhp(integer) {
    return `Php ${integer.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

function convertFromPhp(amount) {
    return parseFloat(amount.replace("Php ", "").replace(/,/g, ""));
}
