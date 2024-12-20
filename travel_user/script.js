document.addEventListener("DOMContentLoaded", function() {
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");
    const featuredResults = document.getElementById("featured-results");

    prevButton.addEventListener("click", function() {
        featuredResults.scrollBy({
            left: -300,  // Di chuyển sang trái
            behavior: 'smooth'
        });
    });

    nextButton.addEventListener("click", function() {
        featuredResults.scrollBy({
            left: 300,  // Di chuyển sang phải
            behavior: 'smooth'
        });
    });
});
