<!-- <nav aria-label="Page navigation example" class="pagination-container">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="?">Previous</a></li>
    <?php foreach($page_links as $page_number => $query): ?>
    <li class="page-item"><a class="page-link" href="?<?php echo e($query); ?>"><?php echo e($page_number+1); ?></a></li>
<?php endforeach; ?>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav> -->

  <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0 mt-6">
        <!-- Previous Page Link -->
        <div class="-mt-px flex w-0 flex-1">
            <?php if ($current_page > 1) : ?>
                <a href="?<?php echo e($previous_page); ?>" class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>
            <?php endif; ?>
        </div>
        <!-- Pages Link -->
        <div class="hidden md:-mt-px md:flex">
            <?php foreach ($page_links as $page_num => $query) : ?>

                <a href="?<?php echo e($query); ?>" class="<?php echo $pageNum + 1 === $currentPage ? "border-indigo-500 text-indigo-600" : "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"; ?>inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium">
                    <?php echo e($page_num+1); ?>
                </a>
            <?php endforeach; ?>
            <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
        </div>
        <!-- Next Page Link -->
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <?php if ($current_page < $last_page) : ?>
                <a href="?<?php echo e($next_page); ?>" class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Next
                    <svg class="ml-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
                    </svg>

                </a>
            <?php endif; ?>
        </div>
    </nav>

<style>
  /* General container styling */


/* Flex container for pagination controls */
.flex {
    display: flex;
}

/* Flex container alignment for pagination items */
.items-center {
    align-items: center;
}

/* Justify content spacing for pagination controls */
.justify-between {
    justify-content: space-between;
}

/* Pagination item styling */
a {
    display: inline-flex;
    align-items: center;
    border-top: 2px solid transparent; /* Border for active state */
    padding: 0.5rem 1rem; /* Padding for each pagination link */
    font-size: 0.875rem; /* Font size for pagination links */
    font-weight: 500; /* Font weight */
    color: #6b7280; /* Text color */
    text-decoration: none; /* Remove underline */
    transition: color 0.2s ease, border-color 0.2s ease; /* Transition effects */
}

/* Styling for hover state */
a:hover {
    border-color: #d1d5db; /* Border color on hover */
    color: #4b5563; /* Text color on hover */
}

/* Active pagination link styling */
a.border-indigo-500 {
    border-color: #4f46e5; /* Border color for the active link */
    color: #4f46e5; /* Text color for the active link */
}

/* SVG icon styling */
svg {
    width: 1.25rem; /* Icon width */
    height: 1.25rem; /* Icon height */
    fill: currentColor; /* Fill color for SVGs */
}

/* Hide pagination links on smaller screens */
.hidden {
    display: none;
}

/* Flexbox adjustments for spacing */
.md\:flex {
    display: flex;
}

/* Adjustments for pagination links */
.md\:-mt-px {
    margin-top: -1px;
}

/* Flexbox adjustments for aligning pagination controls */
.w-0 {
    width: 0;
}

.flex-1 {
    flex: 1;
}

.justify-end {
    justify-content: flex-end;
}

/* Button and link container adjustments */
.pr-1 {
    padding-right: 0.25rem;
}

.pl-1 {
    padding-left: 0.25rem;
}

.pt-4 {
    padding-top: 1rem;
}

.pt-2 {
    padding-top: 0.5rem;
}

</style>