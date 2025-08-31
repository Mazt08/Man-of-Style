document.addEventListener("DOMContentLoaded", () => {
  // -----------------------------
  // Sidebar submenu toggle
  // -----------------------------
  document.querySelectorAll(".has-submenu").forEach(item => {
    item.addEventListener("click", function (e) {
      if (e.target.closest("a")) {
        this.classList.toggle("active");
        const submenu = this.querySelector(".submenu");
        if (submenu) {
          submenu.style.display = submenu.style.display === "block" ? "none" : "block";
        }
      }
    });
  });

  // -----------------------------
  // Elements
  // -----------------------------
  const tableBody = document.querySelector(".users-table tbody");
  const allRows = tableBody ? Array.from(tableBody.querySelectorAll("tr")) : [];
  const searchInput = document.querySelector(".search-box input");
  const filterSelect = document.querySelector(".filter-select");

  // Pagination: prev | 1 2 3 ... | next
  const pag = document.querySelector(".pagination-controls");
  const pagBtns = pag ? Array.from(pag.querySelectorAll(".btn-pagination")) : [];
  const prevBtn = pagBtns[0];
  const nextBtn = pagBtns[pagBtns.length - 1];
  const numBtns = pagBtns.filter(b => /^\d+$/.test(b.textContent.trim()));

  const rowsPerPage = 5;
  let currentPage = 1;

  // -----------------------------
  // Helpers
  // -----------------------------
  function normalizeFilter(value) {
    const v = (value || "").toLowerCase().trim();
    const map = {
      "all users": "all",
      "all": "all",
      "customers": "customer",
      "customer": "customer",
      "staff": "staff",
      "admins": "admin",
      "admin": "admin",
      "banned": "banned"
    };
    return map[v] ?? "all";
  }

  function getRowRole(row) {
    const badge = row.querySelector(".role-badge");
    if (!badge) return "";
    // Prefer class (role-badge admin/staff/customer/banned)
    const roles = ["customer", "staff", "admin", "banned"];
    for (const r of roles) if (badge.classList.contains(r)) return r;
    // Fallback to text
    return badge.textContent.trim().toLowerCase();
  }

  function getFilteredRows() {
    const term = (searchInput?.value || "").toLowerCase();
    const filter = normalizeFilter(filterSelect?.value);

    return allRows.filter(row => {
      const text = row.innerText.toLowerCase();
      const role = getRowRole(row);
      const matchesSearch = text.includes(term);
      const matchesFilter = filter === "all" ? true : role === filter;
      return matchesSearch && matchesFilter;
    });
  }

  function render() {
    if (!tableBody) return;

    const filtered = getFilteredRows();
    const totalPages = Math.max(1, Math.ceil(filtered.length / rowsPerPage));
    if (currentPage > totalPages) currentPage = totalPages;

    // Update numbered buttons
    numBtns.forEach(btn => {
      const n = parseInt(btn.textContent.trim(), 10);
      btn.classList.toggle("active", n === currentPage);
      btn.disabled = n > totalPages;
    });

    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages;

    // Render rows for current page
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    tableBody.innerHTML = "";
    filtered.slice(start, end).forEach(tr => tableBody.appendChild(tr));
  }

  // -----------------------------
  // Events
  // -----------------------------
  searchInput?.addEventListener("input", () => { currentPage = 1; render(); });
  filterSelect?.addEventListener("change", () => { currentPage = 1; render(); });

  numBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      const n = parseInt(btn.textContent.trim(), 10);
      if (!isNaN(n)) { currentPage = n; render(); }
    });
  });

  prevBtn?.addEventListener("click", () => {
    if (currentPage > 1) { currentPage--; render(); }
  });

  nextBtn?.addEventListener("click", () => {
    const totalPages = Math.max(1, Math.ceil(getFilteredRows().length / rowsPerPage));
    if (currentPage < totalPages) { currentPage++; render(); }
  });

  // -----------------------------
  // Export to CSV (all rows, not just visible)
  // -----------------------------
  const exportBtn = document.querySelector(".btn-export");
  exportBtn?.addEventListener("click", () => {
    const table = document.querySelector(".users-table");
    if (!table) return;
    const csv = [];
    table.querySelectorAll("tr").forEach(row => {
      const cols = row.querySelectorAll("th, td");
      const rowData = Array.from(cols).map(col => `"${col.innerText.replace(/"/g, '""')}"`);
      csv.push(rowData.join(","));
    });
    const blob = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url; a.download = "users.csv";
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // Initial render
  render();
});

function logoutUser() {
    if (confirm("Are you sure you want to log out?")) {
        // Clear login session
        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("username");

        alert("Logged out successfully!");
        // Redirect to login.html (outside Admin folder)
        window.location.href = "../login.html";
    }
}