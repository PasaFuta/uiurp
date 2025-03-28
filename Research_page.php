<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container my-4">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for your ideas ..." id="search-bar">
      <button class="btn btn-primary" id="search-bttn">
        <span class="material-symbols-outlined">search</span>
      </button>
    </div>
  </div>

  <section class="container my-5">
    <h2 class="text-center py-4">Search Results</h2>
    <div id="projectsList" class="list-group">
        <!-- Projects will be dynamically added here -->
    </div>
  </section>

  <footer class="bg-dark text-light py-3">
    <div class="container text-center">
      <p>&copy; 2025 UIU</p>
    </div>
  </footer>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const projectsList = document.getElementById('projectsList');
      const searchBar = document.getElementById('search-bar');
      const searchButton = document.getElementById('search-bttn');
      const projectsTab = document.getElementById('projects-tab');

      // Load the first 15 projects when the "Projects" tab is clicked
      projectsTab.addEventListener('click', function(event) {
          event.preventDefault();
          fetch('fetch_projects.php?limit=15')
              .then(response => response.json())
              .then(data => {
                  displayProjects(data);
              });
      });

      // Handle search input
      searchBar.addEventListener('keypress', function(event) {
          if (event.key === 'Enter') {
              const searchString = searchBar.value.trim();
              if (searchString) {
                  handleSearch(searchString);
              }
          }
      });

      // Handle search button click
      searchButton.addEventListener('click', function() {
          const searchString = searchBar.value.trim();
          if (searchString) {
              handleSearch(searchString);
          }
      });

      function handleSearch(searchString) {
          fetch('search_projects.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify({ searchString })
          })
          .then(response => response.json())
          .then(data => {
              displayProjects(data);
          });
      }

      function displayProjects(projects) {
          projectsList.innerHTML = '';
          if (projects && projects.length > 0) {
              const uniqueProjects = [];
              const projectIds = new Set();

              projects.forEach(project => {
                  if (!projectIds.has(project._id.$oid)) {
                      projectIds.add(project._id.$oid);
                      uniqueProjects.push(project);
                  }
              });

              uniqueProjects.forEach(project => {
                  const projectItem = document.createElement('a');
                  projectItem.className = 'list-group-item list-group-item-action d-flex align-items-center';
                  projectItem.href = `Projects_page.html?id=${project._id.$oid}`;
                  projectItem.innerHTML = `
                      <img src="Resources/c9.jpg" alt="Project Image" class="img-fluid rounded me-3 align-items-center" style="height: 100px; width: 200px;">
                      <div class="p-3">
                          <h5 class="mb-1">${project.title}</h5>
                          <p class="mb-1">${project.description}</p>
                          <small>Published Date: January 1, 2023 | Authors: Author 1, Author 2</small>
                      </div>
                  `;
                  projectsList.appendChild(projectItem);
              });
          } else {
              projectsList.innerHTML = '<p class="text-center">No matching projects found.</p>';
          }
      }

      // Load the first 15 projects on page load
      fetch('fetch_projects.php?limit=15')
          .then(response => response.json())
          .then(data => {
              displayProjects(data);
          });
  });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>