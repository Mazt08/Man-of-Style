        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [3200, 4200, 5100, 5800, 6200, 7500],
                        backgroundColor: 'rgba(102, 102, 102, 0.1)',
                        borderColor: 'rgba(102, 102, 102, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Products Chart
            const productsCtx = document.getElementById('productsChart').getContext('2d');
            const productsChart = new Chart(productsCtx, {
                type: 'bar',
                data: {
                    labels: ['Premium Jeans', 'Classic T-Shirt', 'Leather Jacket', 'Sneakers', 'Wool Coat'],
                    datasets: [{
                        label: 'Revenue',
                        data: [5200, 4800, 3900, 3200, 2800],
                        backgroundColor: 'rgba(102, 102, 102, 0.7)',
                        borderColor: 'rgba(102, 102, 102, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Acquisition Chart
            const acquisitionCtx = document.getElementById('acquisitionChart').getContext('2d');
            const acquisitionChart = new Chart(acquisitionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Organic Search', 'Social Media', 'Direct', 'Email', 'Referral'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            'rgba(102, 102, 102, 0.7)',
                            'rgba(136, 136, 136, 0.7)',
                            'rgba(68, 68, 68, 0.7)',
                            'rgba(170, 170, 170, 0.7)',
                            'rgba(204, 204, 204, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: ['Completed', 'Processing', 'Shipped', 'Pending', 'Cancelled'],
                    datasets: [{
                        data: [65, 15, 10, 8, 2],
                        backgroundColor: [
                            'rgba(39, 174, 96, 0.7)',
                            'rgba(41, 128, 185, 0.7)',
                            'rgba(243, 156, 18, 0.7)',
                            'rgba(149, 165, 166, 0.7)',
                            'rgba(231, 76, 60, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Submenu toggle
            document.querySelectorAll('.has-submenu').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (e.target.closest('a')) {
                        this.classList.toggle('active');
                        const submenu = this.querySelector('.submenu');
                        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';

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
                    }
                });
            });
        });