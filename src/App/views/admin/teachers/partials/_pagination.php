<!-- <!DOCTYPE html>
<html>
<head>
    <title>Pagination</title> -->
    <style>
        /* Tailwind CSS Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #e5e7eb;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .pagination-container a {
            display: inline-flex;
            align-items: center;
            border-top: 2px solid transparent; /* Default border */
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280; /* Default text color */
            text-decoration: none;
            transition: color 0.2s ease, border-color 0.2s ease;
        }

        .pagination-container a:hover {
            border-color: #d1d5db;
            color: #4b5563;
        }

        .pagination-container a.active {
            border-color: #4f46e5;
            color: #4f46e5;
        }

        .pagination-container svg {
            width: 1.25rem;
            height: 1.25rem;
            fill: currentColor;
        }

        .pagination-container .hidden {
            display: none;
        }

        .pagination-container .md\:flex {
            display: flex;
        }

        .pagination-container .md\:-mt-px {
            margin-top: -1px;
        }

        .pagination-container .w-0 {
            width: 0;
        }

        .pagination-container .flex-1 {
            flex: 1;
        }

        .pagination-container .justify-end {
            justify-content: flex-end;
        }

        .pagination-container .pr-1 {
            padding-right: 0.25rem;
        }

        .pagination-container .pl-1 {
            padding-left: 0.25rem;
        }

        .pagination-container .pt-4 {
            padding-top: 1rem;
        }

        .pagination-container .pt-2 {
            padding-top: 0.5rem;
        }
    </style>
<!-- </head> -->
<!-- <body> -->

<?php
$pages = range(1, $last_page);
$count = count($pages);
$current_page = isset($_POST['page_num']) ? (int) $_POST['page_num'] : 1;
if($current_page >  $last_page){
  $current_page = $last_page;
}else if($current_page <= 0){
  $current_page = 1;
}
// dd(1==01);
$previous_page = $current_page > 1 ? 'p=' . ($current_page - 1) : null;
$next_page = $current_page < $count ? 'p=' . ($current_page + 1) : null;
?>

<nav class="pagination-container">
    <!-- First Page Link -->
    <?php if ($current_page > 4): ?>
        <!-- <a href="?p=1" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            &lt;&lt;
        </a> -->
        <a href="#" onclick="form_submit(1)" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            &lt;&lt;
        </a>
    <?php endif; ?>

    <!-- Previous Page Link -->
    <?php if ($current_page > 1): ?>
        <!-- <a href="?<?php echo $previous_page; ?>" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            <svg class="mr-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
            </svg>
            Previous
        </a> -->
        <a href="#" onclick="form_submit(<?php echo e($previous_page); ?>)" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            <svg class="mr-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
            </svg>
            Previous
        </a>
    <?php endif; ?>

    <!-- Page Links -->
    <div class="hidden md:flex md:-mt-px">
        <!-- ?p=<?php echo $page_num; ?> -->
        <?php foreach (range(max($current_page - 3, 1), min($current_page + 3, $count)) as $page_num): ?>
            <a href="#" onclick="form_submit(<?php echo e($page_num); ?>)" class="<?php echo $page_num == $current_page ? 'active' : ''; ?>">
                <?php echo $page_num; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="last_page" value="<?php echo e($last_page??1); ?>">
    <!-- Next Page Link -->
    <?php if ($current_page < $count): ?>
       <!--  <a href="?<?php echo $next_page; ?>" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            Next
            <svg class="ml-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
            </svg>
        </a> -->
         <a href="#" onclick="form_submit(<?php echo e($next_page); ?>)" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            Next
            <svg class="ml-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
            </svg>
        </a>
    <?php endif; ?>

    <!-- Last Page Link -->
    <?php if ($current_page < $count): ?>
        <a href="#" onclick="form_submit(<?php echo e($count); ?>)" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            &gt;&gt;
        </a>
        <!-- <a href="?p=<?php echo $count; ?>" class="inline-flex items-center text-gray-500 hover:text-gray-700">
            &gt;&gt;
        </a> -->
    <?php endif; ?>
</nav>

<!-- </body>
</html> -->
