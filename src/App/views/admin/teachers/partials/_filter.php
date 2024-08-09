 <?php
    $subject_names = [];

    if (array_key_exists('subject_names', $_POST)) {
        $subject_names = array_merge($subject_names, $_POST['subject_names']);
    }

    // dd($_POST);
    ?>

 <?php
    $standards_name = [];
    if (array_key_exists('standards_name', $_POST)) {
        $standards_name = array_merge($standards_name, $_POST['standards_name']);
    }

    ?>
 <div class="custom-dropdown">
     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
         <i class="mdi mdi-filter-outline"></i> Filter
     </button>
     <div class="custom-dropdown-menu p-3" id="customDropdownMenu">
         <!-- <form id="filterForm" action="/admin/subjects/filtered_by/" method="POST"> -->
         <div class="dropdown-item">
             <span class="dropdown-label" style="color:black">Subjects</span>
             <div class="dropdown-submenu">
                 <?php foreach ($subjects as $subject) :

                        if (in_array($subject, $subject_names)) :
                    ?>
                         <label>

                             <input type="checkbox" name="subject_names[]" value="<?php echo htmlspecialchars($subject); ?>" checked> <?php echo htmlspecialchars($subject); ?>
                         </label>

                     <?php
                        else :
                        ?>
                         <label>

                             <input type="checkbox" name="subject_names[]" value="<?php echo htmlspecialchars($subject); ?>"> <?php echo htmlspecialchars($subject); ?>
                         </label>

                     <?php endif; ?>




                 <?php endforeach; ?>
             </div>
         </div>
         <div class="dropdown-item">
             <span class="dropdown-label" style="color:black">Standards</span>
             <div class="dropdown-submenu">

                 <?php foreach ($standards as $standard) :

                        if (in_array($standard, $standards_name)) :
                    ?>
                         <label>

                             <input type="checkbox" name="standards_name[]" value="<?php echo htmlspecialchars($standard); ?>" checked> <?php echo htmlspecialchars($standard); ?>
                         </label>

                     <?php
                        else :
                        ?>
                         <label>

                             <input type="checkbox" name="standards_name[]" value="<?php echo htmlspecialchars($standard); ?>"> <?php echo htmlspecialchars($standard); ?>
                         </label>

                     <?php endif; ?>




                 <?php endforeach; ?>
             </div>
         </div>
         <input type="hidden" name="_search_input_" value="<?php echo e($_POST['s'] ?? ''); ?>">
         <input type="hidden" id="order_by" name="order_by" value="name">
         <input type="hidden" id="order" name="order" value="asc">
         <?php if (array_key_exists('subject_names', $_POST)) : foreach ($_POST['subject_names'] as $subs) : ?>
                 <input type="hidden" id="_filter_subs_[]" name="_filter_subs_[]" value="<?php echo e($subs ?? ''); ?>">

             <?php endforeach; ?>
         <?php endif; ?>
         <?php if (array_key_exists('standards_name', $_POST)) : foreach ($_POST['standards_name'] as $std) : ?>
                 <input type="hidden" id="_filter_stds_[]" name="_filter_stds_[]" value="<?php echo e($std ?? ''); ?>">
             <?php endforeach; ?>
         <?php endif; ?>

         <button type="button" onclick="form_submit()" class="btn btn-primary mt-2">Apply Filter</button>


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
     const form_search = document.getElementById("form_search");

     function form_submit() {
         // Select all hidden elements
         const hiddenElements = document.querySelectorAll('input[type="hidden"]');

         // Log all hidden element values to the console
         hiddenElements.forEach(element => {
             console.log(element.name + ": " + element.value);
         });

         form_search.submit();
         // Add your form submission logic here
         // For example: document.getElementById('filterForm').submit();
     }



     function sort(order_by = "name", order = "asc") {
         const hidden_element_order_by = document.getElementById('order_by');
         const hidden_element_order = document.getElementById('order');
         hidden_element_order.value = order;
         hidden_element_order_by.value = order_by;
         console.log(hidden_element_order_by, hidden_element_order);
         form_search.submit();
     }
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