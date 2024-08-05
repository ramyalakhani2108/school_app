<div class="search-container1">
    <form action="/admin/subjects/filtered_by" method="GET">
        <input type="text" name="s" id="searchInput" placeholder="Search subject name,teacher name,standard name, subject_code...">
        <button type="submit" id="searchButton">Search</button>
        <div class="dropdown1" id="searchHistoryDropdown"></div>
    </form>
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