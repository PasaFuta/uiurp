<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU Webpage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style/home.css">

</head>
<body>
  <?php include 'navbar.php'; ?>

  <div id="search">
    <section class="custom-search">
        <input type="text" placeholder="Search for your ideas ..." id="search-bar">
        <button id="search-bttn">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
            <span class="material-symbols-outlined">search</span>
        </button>
    </section>
    
    <div class="tag-cloud container" id="keywordsList">
        <!-- Keywords will be dynamically added here -->
    </div>
  </div>

  <section class="container my-5">
    <h2 class="text-center py-4">Recent Publications from UIU</h2>
    <div id="recentPublicationsCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="resources/Recent research.png" class="d-block w-100" alt="Recent Research">
        </div>
        <div class="carousel-item">
          <!-- Carousel item content -->
          <img src="resources/Recent research.png" class="d-block w-100" alt="Recent Research">
        </div>
        <div class="carousel-item">
          <!-- Carousel item content -->
          <img src="resources/Recent research.png" class="d-block w-100" alt="Recent Research">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#recentPublicationsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#recentPublicationsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <section class="bg-light py-5" id="faq-section">
    <div class="container">
      <h3 class="text-center">Want to do Research? Do you already know these</h3>
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="accordion" id="faqAccordionLeft">
            <!-- FAQs will be dynamically added here -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="accordion" id="faqAccordionRight">
            <!-- FAQs will be dynamically added here -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-light py-3">
    <div class="container text-center">
      <p>&copy; 2025 UIU</p>
    </div>
  </footer>

  <script>
    
  document.addEventListener('DOMContentLoaded', function() {
      const searchBar = document.getElementById('search-bar');
      const keywordsList = document.getElementById('keywordsList');
      
      // Fetch and display the frequently searched keywords
      fetch('fetch_keywords.php')
          .then(response => response.json())
          .then(data => {
            console.log("hello world");
              keywordsList.innerHTML = '';
              data.forEach(keyword => {
                  console.log("hello world");
                  const span = document.createElement('span');
                  span.textContent = keyword.name;
                  span.style.cursor = 'pointer';
                  span.addEventListener('mouseover', () => span.style.backgroundColor = '#f0f0f0');
                  span.addEventListener('mouseout', () => span.style.backgroundColor = '#d8d8d8');
                  span.addEventListener('click', () => {
                      searchBar.value = keyword.name;
                      handleSearch(keyword.name);
                  });
                  keywordsList.appendChild(span);
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
              // Redirect to Research_page.html with the search results
              localStorage.setItem('searchResults', JSON.stringify(data));
              window.location.href = 'Research_page.html';
          });
      }

      // Fetch and display the FAQs
      fetch('fetch_faqs.php')
          .then(response => response.json())
          .then(data => {
              const faqAccordionLeft = document.getElementById('faqAccordionLeft');
              const faqAccordionRight = document.getElementById('faqAccordionRight');
              faqAccordionLeft.innerHTML = '';
              faqAccordionRight.innerHTML = '';
              data.forEach((faq, index) => {
                  const accordionItem = document.createElement('div');
                  accordionItem.className = 'accordion-item m-4';
                  accordionItem.innerHTML = `
                      <h2 class="accordion-header" id="heading${index}">
                          <button class="accordion-button ${index !== 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                              ${faq.question}
                          </button>
                      </h2>
                      <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}">
                          <div class="accordion-body">
                              ${faq.answer}
                          </div>
                      </div>
                  `;
                  if (index % 2 === 0) {
                      faqAccordionLeft.appendChild(accordionItem);
                  } else {
                      faqAccordionRight.appendChild(accordionItem);
                  }
              });
          });
  });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>