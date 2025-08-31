document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const searchResultsHeader = document.getElementById('searchResultsHeader');
    const searchResultsText = document.getElementById('searchResultsText');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    
    // Search functionality
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        currentSearchTerm = searchInput.value.toLowerCase().trim();
        
        if (currentSearchTerm === '') {
            clearSearch();
            return;
        }
        
        applyFilters();
        
        // Show search results header
        const filteredCount = document.querySelectorAll('#productContainer .col-lg-3').length;
        searchResultsText.textContent = `Showing ${filteredCount} results for "${currentSearchTerm}"`;
        searchResultsHeader.style.display = 'block';
    });
    
    // Clear search functionality
    clearSearchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        clearSearch();
    });
    
    // Function to clear search
    function clearSearch() {
        searchInput.value = '';
        currentSearchTerm = '';
        applyFilters();
        searchResultsHeader.style.display = 'none';
    }
});