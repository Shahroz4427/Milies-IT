console.log("Checking if JavaScript is running...");

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM is ready!");
});

window.addEventListener("load", function () {
    console.log("Page has fully loaded!");
});


document.addEventListener("DOMContentLoaded", function () {
    console.log("Script loaded: DOM is ready");

    function initVimeoFacade() {
        let facadeElements = document.querySelectorAll(".facade-method");

        if (facadeElements.length === 0) {
            console.warn("No .facade-method elements found on this page.");
            return;
        }

        console.log(`Found ${facadeElements.length} .facade-method elements`);

        facadeElements.forEach(function (facade) {
            facade.addEventListener("click", function (event) {
                console.log("?? Facade clicked!"); // Debugging click

                event.preventDefault(); // Prevent default behavior

                var videoId = this.getAttribute("data-vimeo-id");
                if (!videoId) {
                    console.error("No Vimeo ID found on clicked element.");
                    return;
                }
                console.log(`Video ID: ${videoId}`);

                var vimeoUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                console.log(`?? Vimeo URL: ${vimeoUrl}`);

                // Create iframe
                var iframe = document.createElement("iframe");
                iframe.setAttribute("src", vimeoUrl);
                iframe.setAttribute("frameborder", "0");
                iframe.setAttribute("allow", "autoplay; fullscreen");
                iframe.setAttribute("allowfullscreen", "");

                // Apply styling
                iframe.style.width = "100%";
                iframe.style.height = "100%";
                iframe.style.position = "absolute";
                iframe.style.top = "0";
                iframe.style.left = "0";

                // Replace thumbnail with iframe
                var facadeContainer = this.querySelector(".vimeo-facade");
                if (!facadeContainer) {
                    console.error(".vimeo-facade element not found inside facade.");
                    return;
                }

                facadeContainer.innerHTML = ""; // Clear content
                facadeContainer.appendChild(iframe);
                console.log("Vimeo iframe inserted successfully!");
            });
        });
    }

    // Run function on initial load
    initVimeoFacade();

    // Also ensure it works on dynamically loaded elements (e.g., AJAX)
    document.addEventListener("ajaxComplete", initVimeoFacade);
});
