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
function convertToReadableDateTime(date) {
    if (!date || date === "0000-00-00") {
        return "No Date Recorded Yet";
    }

    const parsedDate = new Date(date);
    if (isNaN(parsedDate.getTime())) {
        return "Invalid Date";
    }

    const options = { year: "numeric", month: "short", day: "numeric" };
    const datePart = parsedDate.toLocaleDateString("en-US", options);

    let hours = parsedDate.getHours();
    const minutes = String(parsedDate.getMinutes()).padStart(2, "0");
    const ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12; // Convert to 12-hour format

    return `${datePart} ${hours}:${minutes} ${ampm}`;
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

function formatTimeAgo(dateTime) {
    let now = new Date();
    let notificationDate = new Date(dateTime);
    let diffInSeconds = Math.floor((now - notificationDate) / 1000);

    if (diffInSeconds < 300) {
        return "Just Now";
    } else if (diffInSeconds < 3600) {
        let minutes = Math.floor(diffInSeconds / 60);
        return minutes === 1 ? `A minute ago` : `${minutes} minutes ago`;
    } else if (diffInSeconds < 86400) {
        let hours = Math.floor(diffInSeconds / 3600);
        return hours === 1 ? "An hour ago" : `${hours} hours ago`;
    } else if (diffInSeconds < 172800) {
        return "Yesterday";
    } else if (diffInSeconds < 604800) {
        let days = Math.floor(diffInSeconds / 86400);
        return days === 1 ? "A day ago" : `${days} days ago`;
    } else if (diffInSeconds < 2592000) {
        let weeks = Math.floor(diffInSeconds / 604800);
        return weeks === 1 ? "A week ago" : `${weeks} weeks ago`;
    } else if (diffInSeconds < 31536000) {
        let months = Math.floor(diffInSeconds / 2592000);
        return months === 1 ? "A month ago" : `${months} months ago`;
    } else {
        let years = Math.floor(diffInSeconds / 31536000);
        return years === 1 ? "A year ago" : `${years} years ago`;
    }
}
