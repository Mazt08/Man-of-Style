// Admin.js - Man Of Style Admin Dashboard JavaScript

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeAdminDashboard();
});

// Main Initialization Function
function initializeAdminDashboard() {
    // Initialize all components
    setupNavigation();
    setupSearch();
    setupNotifications();
    setupWidgets();
    setupDataTables();
    setupQuickActions();
    setupActivityLog();
    setupUserProfile();
}

// Navigation Setup
function setupNavigation() {
    const navItems = document.querySelectorAll('.admin-nav li');
    
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            navItems.forEach(navItem => {
                navItem.classList.remove('active');
            });
            
            // Add active class to clicked item
            this.classList.add('active');
        });
    });
    
    // Logout button functionality
    const logoutBtn = document.querySelector('.btn-logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            performLogout();
        });
    }
}

// Search Functionality
function setupSearch() {
    const searchBox = document.querySelector('.search-box');
    const searchInput = searchBox.querySelector('input');
    
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            performSearch(this.value);
        }
    });
    
    searchBox.querySelector('i').addEventListener('click', function() {
        performSearch(searchInput.value);
    });
}

function performSearch(query) {
    if (query.trim() !== '') {
        // In a real application, this would make an API call
        console.log(`Searching for: ${query}`);
        alert(`Search functionality would look for: ${query}`);
        // You would typically redirect to a search results page or filter the current view
    }
}

// Notifications Setup
function setupNotifications() {
    const notifications = document.querySelector('.notifications');
    
    notifications.addEventListener('click', function() {
        // In a real application, this would toggle a notifications dropdown
        alert('Notifications dropdown would appear here');
        // You could also mark notifications as read and update the badge
        const badge = this.querySelector('.badge');
        if (badge) {
            badge.textContent = '0';
            badge.style.display = 'none';
        }
    });
}

// Widgets Setup
function setupWidgets() {
    const widgets = document.querySelectorAll('.widget');
    
    widgets.forEach(widget => {
        widget.addEventListener('click', function() {
            // Add visual feedback when widget is clicked
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
            
            // Navigate to relevant section based on widget type
            const widgetType = this.querySelector('h3').textContent;
            handleWidgetClick(widgetType);
        });
    });
}

function handleWidgetClick(widgetType) {
    switch(widgetType) {
        case "Today's Orders":
            window.location.href = "management.html";
            break;
        case "Revenue":
            window.location.href = "report.html";
            break;
        case "New Customers":
            window.location.href = "user.html";
            break;
        case "Low Stock":
            window.location.href = "product.html";
            break;
        default:
            console.log(`Widget clicked: ${widgetType}`);
    }
}

// Data Tables Setup
function setupDataTables() {
    const viewAllBtn = document.querySelector('.btn-view-all');
    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', function() {
            window.location.href = "management.html";
        });
    }
    
    // Action buttons in table rows
    const actionButtons = document.querySelectorAll('.action-buttons button');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.classList[1]; // view, edit, or delete
            const row = this.closest('tr');
            const orderId = row.querySelector('td:first-child').textContent;
            
            handleOrderAction(action, orderId, row);
        });
    });
}

function handleOrderAction(action, orderId, row) {
    switch(action) {
        case 'view':
            alert(`View details for order: ${orderId}`);
            // In a real app, this would open a modal or redirect to order details
            break;
        case 'edit':
            alert(`Edit order: ${orderId}`);
            // In a real app, this would open an edit form
            break;
        case 'delete':
            if (confirm(`Are you sure you want to delete order ${orderId}?`)) {
                // Visual feedback for deletion
                row.style.opacity = '0.5';
                row.style.backgroundColor = '#ffeeee';
                
                // In a real app, this would make an API call to delete the order
                setTimeout(() => {
                    row.remove();
                    updateOrderStats(); // Would update the widget counts
                }, 1000);
            }
            break;
    }
}

// Quick Actions Setup
function setupQuickActions() {
    const actionButtons = document.querySelectorAll('.action-buttons button');
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const actionType = this.classList[0]; // btn-action-primary, etc.
            
            switch(actionType) {
                case 'btn-action-primary':
                    window.location.href = "product.html#add";
                    break;
                case 'btn-action-secondary':
                    alert('Open promotion creation modal');
                    break;
                case 'btn-action-tertiary':
                    window.location.href = "report.html#generate";
                    break;
            }
        });
    });
}

// Activity Log Setup
function setupActivityLog() {
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        item.addEventListener('click', function() {
            // In a real app, this might expand to show more details
            const activityText = this.querySelector('p').textContent;
            console.log(`Activity clicked: ${activityText}`);
        });
    });
}

// User Profile Setup
function setupUserProfile() {
    const userAvatar = document.querySelector('.user-avatar');
    if (userAvatar) {
        userAvatar.addEventListener('click', function() {
            alert('User profile dropdown would appear here');
        });
    }
}

// Logout Function
function performLogout() {
    if (confirm('Are you sure you want to logout?')) {
        // In a real application, this would clear authentication tokens
        // and redirect to the login page
        console.log('Logging out...');
        
        // Simulate logout process
        document.body.style.opacity = '0.7';
        setTimeout(() => {
            window.location.href = "login.html";
        }, 500);
    }
}

// Utility Functions
function updateOrderStats() {
    // This function would update the widget counts after changes
    console.log('Updating order statistics...');
    // In a real app, this would make API calls to get updated data
}

// Export functions for potential use in other modules (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initializeAdminDashboard,
        performSearch,
        handleOrderAction,
        performLogout
    };
}

function logoutUser() {
    // Clear login data
    localStorage.removeItem("isLoggedIn");
    localStorage.removeItem("username");

    // Redirect to login page
    window.location.href = "../login.html";
  }