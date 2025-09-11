/* ==========================
   Sidebar Submenu Toggle
========================== */
document.querySelectorAll('.has-submenu > a').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const parent = this.parentElement;
        parent.classList.toggle('active');

        let submenu = parent.querySelector('.submenu');
        if (submenu) {
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        }
    });
});

/* ==========================
   Logout Button Confirmation
========================== */
const logoutBtn = document.querySelector('.btn-logout');
if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        if (confirm("Are you sure you want to log out?")) {
            alert("Logged out successfully!");
            window.location.href = "../login.html"; // change if different
        }
    });
}

/* ==========================
   Search Filter (Orders)
========================== */
const searchInput = document.querySelector('.search-box input');
if (searchInput) {
    searchInput.addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.orders-table tbody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}

/* ==========================
   Order Management Page
========================== */

// Open modal when clicking "View"
document.querySelectorAll('.btn-action.view').forEach(btn => {
    btn.addEventListener('click', function () {
        const modal = document.getElementById('orderDetailsModal');
        if (modal) modal.style.display = 'block';
    });
});

// Close modal
const closeModalBtn = document.querySelector('.btn-close-modal');
if (closeModalBtn) {
    closeModalBtn.addEventListener('click', function () {
        const modal = document.getElementById('orderDetailsModal');
        if (modal) modal.style.display = 'none';
    });
}

// Close modal when clicking outside content
window.addEventListener('click', function (e) {
    const modal = document.getElementById('orderDetailsModal');
    if (modal && e.target === modal) {
        modal.style.display = 'none';
    }
});

/* ==========================
   Export & Refresh Buttons
========================== */
const exportBtn = document.querySelector('.btn-export');
if (exportBtn) {
    exportBtn.addEventListener('click', () => {
        alert("Exporting orders to CSV...");
        // TODO: add real export logic
    });
}

const refreshBtn = document.querySelector('.btn-refresh');
if (refreshBtn) {
    refreshBtn.addEventListener('click', () => {
        alert("Refreshing orders...");
        location.reload(); // refresh page
    });
}

/* ==========================
   Status Filter (Orders)
========================== */
const filterSelect = document.querySelector('.filter-select');
if (filterSelect) {
    filterSelect.addEventListener('change', function () {
        let selected = this.value.toLowerCase();
        let rows = document.querySelectorAll('.orders-table tbody tr');

        rows.forEach(row => {
            let statusCell = row.querySelector('.status-badge');
            if (!statusCell) return;

            let status = statusCell.textContent.trim().toLowerCase();

            if (selected === "all statuses" || status === selected) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}

/* ==========================
   Date Filter (Orders)
========================== */
const dateInput = document.querySelector('.date-filter');
const filterBtn = document.querySelector('.btn-filter');

if (dateInput && filterBtn) {
    filterBtn.addEventListener('click', function () {
        let selectedDate = dateInput.value; // yyyy OR yyyy-mm OR yyyy-mm-dd
        let rows = document.querySelectorAll('.orders-table tbody tr');

        rows.forEach(row => {
            let orderDateCell = row.querySelector('td:nth-child(3)'); // 3rd column = Date
            if (!orderDateCell) return;

            let orderDate = orderDateCell.textContent.trim(); // format: yyyy-mm-dd

            if (!selectedDate) {
                row.style.display = "";
                return;
            }

            if (orderDate.startsWith(selectedDate)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}

