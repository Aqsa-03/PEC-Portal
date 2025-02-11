<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fyp";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Sorry, failed to connect: " . mysqli_connect_error());
}

// Check if the delete button is clicked
if (isset($_POST['deleteBtn'])) {
  $idToDelete = mysqli_real_escape_string($conn, $_POST['idToDelete']);

  // Perform the delete operation
  $deleteSql = "DELETE FROM internees WHERE id = $idToDelete";
  $deleteResult = mysqli_query($conn, $deleteSql);

  if ($deleteResult) {
    echo "success";
    exit; // Stop further execution
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
    exit; // Stop further execution
  }
}

$sql = "SELECT id, fullName, ntnNumber, cnicNo, emailAddress, phoneNo, dateofBirth, graduationYear, education, discipline, industry, preferredCity, registrationTimestamp, address FROM internees";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Error in SQL query: " . mysqli_error($conn));
}


?>



<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./css/tailwind.output.css" />
  <link rel="icon" type="image/x-icon" href="logo.png">
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="./js/init-alpine.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
  <script src="./js/charts-lines.js" defer></script>
  <script src="./js/charts-pie.js" defer></script>
</head>

<body>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
    <!-- Desktop sidebar -->
    <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
      <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="flex flex-wrap h-full items-center ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
          href="adminDashboard.php">
          <img src="./img/logo.png" style="max-height: 4rem" class="w-1/4" alt="main_logo" />

          <div class="w-3/4 flex flex-wrap ml-4">
            <span class="w-full">PEC</span>
            <span class="text-sm">INTERNEE PORTAL</span>
          </div>
        </a>
        <ul class="mt-6">
          <li class="relative px-6 py-3">

            <a class="inline-flex items-center w-full text-sm font-semibold  transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
              href="adminDashboard.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
              </svg>
              <span class="ml-4">Dashboard</span>
            </a>
          </li>
        </ul>
        <ul>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="adminJL.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <!-- <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path> -->
              </svg>
              <!-- <span class="ml-4">Job List</span> -->
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="adminVR.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <!-- <path
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path> -->
              </svg>
              <!-- <span class="ml-4">View Resume</span> -->
            </a>
          </li>
         

          <li class="relative px-6 py-3">
            <button
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              @click="togglePagesMenu" aria-haspopup="true">
              <span class="inline-flex items-center">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <!-- <path
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                  </path> -->
                </svg>
                <!-- <span class="ml-4">Contact Details</span> -->
              </span>
              <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <!-- <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path> -->
              </svg>
            </button>
            <!-- <template x-if="isPagesMenuOpen"> -->
              <!-- <ul x-transition:enter="transition-all ease-in-out duration-300"
                x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu"> -->
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  <!-- <a class="w-full" href="adminECD.php">Engineer Contact Details</a> -->
                </li>
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  <!-- <a class="w-full" href="adminCCD.php">
                    Company Contact Details
                  </a> -->
                </li>

              </ul>
            </template>
          </li>
        </ul>

      </div>
    </aside>
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
    <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
      x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
      x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
      @keydown.escape="closeSideMenu">
      <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="flex flex-wrap h-full items-center ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
          <img src="./img/logo.png" style="max-height: 4rem" class="w-1/4" alt="main_logo" />

          <div class="w-3/4 flex flex-wrap ml-4">
            <span class="w-full">PEC</span>
            <span class="text-sm">INTERNEE PORTAL</span>
          </div>
        </a>
        <ul class="mt-6">
          <li class="relative px-6 py-3">

            <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
              href="adminDashboard.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
              </svg>
              <span class="ml-4">Dashboard</span>
            </a>
          </li>
        </ul>
        <ul>
          <li class="relative px-6 py-3">

            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="adminJL.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path>
              </svg>
              <span class="ml-4">Job List</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="adminVR.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
              </svg>
              <span class="ml-4">View Resume</span>
            </a>
          </li>
         

          <li class="relative px-6 py-3">
            <button
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              @click="togglePagesMenu" aria-haspopup="true">
              <span class="inline-flex items-center">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                  </path>
                </svg>
                <span class="ml-4">Contact Details</span>
              </span>
              <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
            <template x-if="isPagesMenuOpen">
              <ul x-transition:enter="transition-all ease-in-out duration-300"
                x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu">
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  <a class="w-full" href="adminECD.php">Engineer Contact Details</a>
                </li>
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  <a class="w-full" href="adminCCD.php">
                    Company Contact Details
                  </a>
                </li>

              </ul>
            </template>
          </li>
        </ul>

      </div>
    </aside>
    <div class="flex flex-col flex-1 w-full">
      <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
        <div
          class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
          <!-- Mobile hamburger -->
          <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu" aria-label="Menu">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"></path>
            </svg>
          </button>
          <!-- Search input -->
          <div class="flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-600">
              <div class="absolute inset-y-0 flex items-center pl-2">
                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
              <input
                class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                type="text" placeholder="Search" aria-label="Search" />
            </div>
          </div>

        </div>
      </header>
      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            TOTAL REGISTERED INTERNEES
          </h2>
          <!-- CTA -->
          <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
            href="#">
            <div class="flex w-full  items-center text-center">

              <span class="text-center w-full text-lg">Pakistan Engineering Council - Internee Portal</span>
            </div>
          </a>
          <div class="relative w-full max-w-xl mr-6 mb-6 focus-within:text-purple-600">
            <div class="absolute inset-y-0 flex items-center pl-2">
              <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
              </svg>
            </div>
            <input
              class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
              type="text" placeholder="Search" aria-label="Search" id="searchInput" oninput="filterTable()" />
          </div>
          <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap" id="dataTable">
                <thead>
                  <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                  <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">NAME</th>
                    <th class="px-4 py-3">ENGINEER ID</th>
                    <th class="px-4 py-3">CNIC</th>
                    <th class="px-4 py-3">EMAIL</th>

                    <th class="px-4 py-3">Phone No #</th>
                    <th class="px-4 py-3">Date OF Birth</th>
                    <th class="px-4 py-3">GRADUATION YEAR</th>
                    <th class="px-4 py-3">Education</th>
                    <th class="px-4 py-3">Discipline</th>
                    <th class="px-4 py-3">Industry</th>
                    <th class="px-4 py-3">PREFERRED CITY</th>
                    <th class="px-4 py-3">Address</th>
                    <th class="px-4 py-3">TimeStamp</th>
                    <th class="px-4 py-3">ASSIGN TASK</th>
                    <th class="px-4 py-3">View Task</th>

                    <th class="px-4 py-3">Delete Record</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  <?php
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='text-gray-700 dark:text-gray-400'>";
                    echo "<td class='px-4 py-3'><div class='flex items-center text-sm'><div class='relative hidden w-8 h-8 mr-3 rounded-full md:block'></div><div><p class='font-semibold'>" . $row['id'] . "</p></div></div></td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['fullName'] . "</td>";
                    echo "<td class='px-4 py-3 text-xs'><span class='px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100'>" . $row['ntnNumber'] . "</span></td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['cnicNo'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['emailAddress'] . "</td>";
                  

                    echo "<td class='px-4 py-3 text-sm'>" . $row['phoneNo'] . "</td>";

                    echo "<td class='px-4 py-3 text-sm'>" . $row['dateofBirth'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['graduationYear'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['education'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['discipline'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['industry'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['preferredCity'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['address'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'>" . $row['registrationTimestamp'] . "</td>";
                    echo "<td class='px-4 py-3 text-sm'><a href='./adminTaskAssign.php?id=" . $row['id'] . "' class='delete-btn px-2 py-1'>Assign</a></td>";
                    echo "<td class='px-4 py-3 text-sm'><a href='./adminViewTask.php?id=" . $row['id'] . "' class='delete-btn px-2 py-1'>view</a></td>";
                    echo "<td class='px-4 py-3 text-sm'><button class='delete-btn px-2 py-1 ' onclick='deleteRecord(" . $row['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>

            </div>
            
          </div>
        </div>
      </main>
    </div>
  </div>
  <script>
    function deleteRecord(id) {
      if (confirm("Are you sure you want to delete this record?")) {
        // Using AJAX to delete the record without refreshing the page
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText == "success") {
              alert("Record deleted successfully");

              // Remove the deleted row from the table
              var deletedRow = document.getElementById("recordsTableBody").querySelector("tr[data-id='" + id + "']");
              if (deletedRow) {
                deletedRow.remove();
              }
            } else {
              alert("Error deleting record: " + xhr.responseText);
            }
          }
        };
        xhr.open("POST", "", true); // The empty string in the URL means the current page
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("deleteBtn=1&idToDelete=" + id);
      }
    }
  </script>
   <script>
    function filterTable() {
        // Declare variables
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows
        for (i = 0; i < tr.length; i++) {
            var showRow = false;
            // Loop through all cells in the current row
            for (j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // If any cell contains the search query, set showRow to true
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        showRow = true;
                        break; // Break the inner loop since we found a match in this row
                    }
                }
            }

            // Show/hide the row based on the match
            if (showRow) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>

</body>

</html>