<div class="custom-dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
        <i class="mdi mdi-filter-outline"></i> Filter
    </button>
    <div class="custom-dropdown-menu p-3" id="customDropdownMenu">
        <form id="filterForm" action="/admin/standards" method="POST">
            <div class="dropdown-item">
                <span class="dropdown-label" style="color:black">Teachers</span>
                <div class="dropdown-submenu">
                    <?php foreach ($teachers as $teacher) : ?>
                        <label>
                            <input type="checkbox" name="teacher_names[]" value="<?php echo htmlspecialchars($teacher); ?>"> <?php echo htmlspecialchars($teacher); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="dropdown-item">
                <span class="dropdown-label" style="color:black">Subjects</span>
                <div class="dropdown-submenu">

                    <?php

                    foreach ($subjects as $subject) : ?>
                        <label>
                            <input type="checkbox" name="subjects_name[]" value="<?php echo htmlspecialchars($subject); ?>"> <?php echo htmlspecialchars($subject); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.getElementById('dropdownMenuButton');
        const customDropdownMenu = document.getElementById('customDropdownMenu');

        dropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            customDropdownMenu.style.display = customDropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(e) {
            if (!dropdownButton.contains(e.target) && !customDropdownMenu.contains(e.target)) {
                customDropdownMenu.style.display = 'none';
            }
        });

        document.querySelectorAll('.dropdown-label').forEach(label => {
            label.addEventListener('click', function(e) {
                e.stopPropagation();
                const submenu = this.nextElementSibling;
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            });
        });
    });
</script>
<style>
    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 250px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 10px;
        border-radius: 4px;
        max-height: 400px;
        /* Set max height for scrollability */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .dropdown-item {
        position: relative;
    }

    .dropdown-item:hover {
        background-color: aquamarine;
        color: black;
    }

    .dropdown-label {
        display: block;
        padding: 8px 10px;
        cursor: pointer;
        font-weight: bold;
    }

    .dropdown-submenu {
        color: black;
        display: none;
        position: relative;
        background-color: white;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        padding: 10px;
        border-radius: 4px;
        max-height: 200px;
        /* Set max height for scrollability */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .dropdown-submenu label {
        display: block;
        padding: 8px 10px;
        cursor: pointer;
    }

    .dropdown-submenu label:hover {
        background-color: #f1f1f1;
    }

    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 250px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 10px;
        border-radius: 4px;
    }

    .dropdown-item {
        position: relative;
    }

    .dropdown-item:hover {
        background-color: aquamarine;
        color: black;
    }

    .dropdown-label {
        display: block;
        padding: 8px 10px;
        cursor: pointer;
        font-weight: bold;
    }

    .dropdown-submenu {
        color: black;
        display: none;
        position: relative;
        background-color: white;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        padding: 10px;
        border-radius: 4px;
    }

    .dropdown-submenu label {
        display: block;
        padding: 8px 10px;
        cursor: pointer;
    }

    .dropdown-submenu label:hover {
        background-color: #f1f1f1;
    }
</style>