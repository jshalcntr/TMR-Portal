document.addEventListener("DOMContentLoaded", function () {
  const elements = {
    hot: document.getElementById("prospectType_hot"),
    warm: document.getElementById("prospectType_warm"),
    cold: document.getElementById("prospectType_cold"),
    lost: document.getElementById("prospectType_lost"),
    tableBody: document.getElementById("prospectTableBody"),
  };

  const hotModal = document.getElementById("prospectTypeHotModal");
  if (hotModal) {
    new bootstrap.Modal(hotModal, {
      backdrop: "static",
      keyboard: false,
    });
  }

  function getCount(counts, ...keys) {
    for (let key of keys) {
      const value = counts[key];
      if (typeof value === "number" && value > 0) return value;
    }
    return 0;
  }

  fetch("/tmr-portal/backend/sales-management/getProspectData.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      if (data.status === "success") {
        const counts = data.all_counts || {};

        if (elements.hot) {
          elements.hot.textContent = getCount(counts, "prospectType_Hot");
        }
        if (elements.warm) {
          elements.warm.textContent = getCount(counts, "prospectType_Warm");
        }
        if (elements.cold) {
          elements.cold.textContent = getCount(counts, "prospectType_Cold");
        }
        if (elements.lost) {
          elements.lost.textContent = getCount(counts, "prospectType_Lost");
        }

        if (elements.tableBody && data.prospects) {
          elements.tableBody.innerHTML = "";
          data.prospects.forEach((prospect) => {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td>${prospect.id || ""}</td>
              <td>${prospect.name || ""}</td>
              <td>${prospect.email || ""}</td>
              <td>${prospect.prospect_type || ""}</td>
            `;
            elements.tableBody.appendChild(row);
          });
        }
      } else {
        throw new Error(data.message || "Failed to load prospect data");
      }
    })
    .catch((error) => {
      console.error("Error fetching prospect data:", error);
      Object.values(elements).forEach((el) => {
        if (el && el !== elements.tableBody) el.textContent = "Error";
      });
      if (elements.tableBody) {
        elements.tableBody.innerHTML = `<tr><td colspan="4">Error loading data</td></tr>`;
      }
    });
});
