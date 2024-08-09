<div class="search-container1">
    <form id="form_search" action="" method="POST">
        <input type="text" name="s" id="searchInput" value="<?php echo e($_POST['s'] ?? $_POST['_search_input_'] ?? $_POST['_search_input_'] ?? ''); ?>" placeholder="Search subject name,teacher name,standard name, subject_code...">
        <button type="submit" id="searchButton">Search</button>
        <div class="dropdown1" id="searchHistoryDropdown"></div>
        <!-- </form> -->
</div>
<style>
    .search-container1 {
        position: relative;
        display: inline-block;
    }

    #searchInput {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 600px;


    }

    #searchButton {
        padding: 10px 15px;
        font-size: 16px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #searchButton:hover {
        background-color: #218838;
    }

    .dropdown1 {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        display: none;
        padding: 5px 0;
        margin: 0;
        font-size: 14px;
        color: #212529;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 4px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
    }

    .dropdown-item {
        padding: 10px 20px;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        cursor: pointer;
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        color: #16181b;
        text-decoration: none;
        background-color: #f8f9fa;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const searchHistoryDropdown = document.getElementById('searchHistoryDropdown');
        let searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || [];

        // Function to update the dropdown with search history
        function updateDropdown() {
            searchHistoryDropdown.innerHTML = '';
            if (searchHistory.length > 0) {
                searchHistoryDropdown.style.display = 'block';
                searchHistory.slice(-5).reverse().forEach((term) => {
                    const item = document.createElement('div');
                    item.classList.add('dropdown-item');
                    item.textContent = term;
                    item.addEventListener('click', () => {
                        searchInput.value = term;
                        searchHistoryDropdown.style.display = 'none';
                    });
                    searchHistoryDropdown.appendChild(item);
                });
            } else {
                searchHistoryDropdown.style.display = 'none';
            }
        }

        // Add event listener to the search button
        searchButton.addEventListener('click', () => {
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                if (!searchHistory.includes(searchTerm)) {
                    searchHistory.push(searchTerm);
                    localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
                }
                updateDropdown();
            }
        });

        // Show the dropdown when the search input is focused
        searchInput.addEventListener('focus', () => {
            updateDropdown();
        });

        // Hide the dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.search-container')) {
                searchHistoryDropdown.style.display = 'none';
            }
        });

        // Initialize the dropdown with search history
        updateDropdown();
    });
</script>