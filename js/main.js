(function ($) {
    "use strict";
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top');
        } else {
            $('.nav-bar').removeClass('sticky-top');
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    
})(jQuery);


function toggleUpdateSection() {
    document.getElementById('change-btn').classList.add('hidden');
    document.getElementById('update-section').classList.remove('hidden');
}

document.addEventListener("DOMContentLoaded", function () {
    // Check if 'type_id' is present in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const typeId = urlParams.get("type_id");
    const cityId = urlParams.get("city_id");
    const keyword = urlParams.get("keyword");

    if (typeId || cityId || keyword) {
        // Scroll to the specific div
        const targetDiv = document.getElementById("property-listing");
        if (targetDiv) {
            window.scrollTo({
                top: targetDiv.offsetTop, // Scroll to the start of the target div
                behavior: 'smooth' // Smooth scroll effect
            });
        }
    }
});


// Call this function when the page is loaded
window.onload = scrollToElementBasedOnType;


document.addEventListener("DOMContentLoaded", function () {
    // Check if 'type_id' is present in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const typeId = urlParams.get("type_id");

    if (typeId) {
        // Fetch the property type based on type_id
        const propertyTypes = {
            1: 'House',
            2: 'Apartment',
            3: 'Villa',
            4: 'Office',
            5: 'Shope',
            6: 'Townhouse',
            7: 'Garage',
            8: 'Building'
            // Add more types as needed
        };

        // Get the type name based on type_id
        const propertyTypeName = propertyTypes[typeId];

        // If property type exists, inject it into the HTML with a custom class
        if (propertyTypeName) {
            const propertyTypeDiv = document.getElementById("property-type-div");
            propertyTypeDiv.innerHTML = `<h1 class="mb-3">Property Listing - <span style="color: #00B98E;"> ${propertyTypeName}</span></h1>`;
        }

        // Scroll to the property listing section (optional)
        const targetDiv = document.getElementById("property-listing");
        if (targetDiv) {
            targetDiv.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    function getWishlist() {
        const wishlistCookie = document.cookie
            .split("; ")
            .find((row) => row.startsWith("wishlist="));
        try {
            return wishlistCookie ? JSON.parse(decodeURIComponent(wishlistCookie.split("=")[1])) : [];
        } catch (error) {
            console.error("Failed to parse wishlist cookie:", error);
            return [];
        }
    }

    function saveWishlist(wishlist) {
        const expiryDate = new Date();
        expiryDate.setFullYear(expiryDate.getFullYear() + 1);
        document.cookie = `wishlist=${encodeURIComponent(
            JSON.stringify(wishlist)
        )}; expires=${expiryDate.toUTCString()}; path=/`;
    }

    function updateWishlistButtons() {
        const wishlist = getWishlist();
        document.querySelectorAll(".wishlist-btn").forEach((button) => {
            const propertyId = button.getAttribute("data-property-id");
            if (wishlist.includes(propertyId)) {
                button.classList.add("active");
                button.innerHTML = '<i class="fa fa-heart"></i> Added to Wishlist';
            } else {
                button.classList.remove("active");
                button.innerHTML = '<i class="fa fa-heart-o"></i> Add to Wishlist';
            }
        });
    }

    document.body.addEventListener("click", function (e) {
        if (e.target.closest(".wishlist-btn")) {
            const button = e.target.closest(".wishlist-btn");
            const propertyId = button.getAttribute("data-property-id");
            let wishlist = getWishlist();

            if (wishlist.includes(propertyId)) {
                wishlist = wishlist.filter((id) => id !== propertyId);
                alert("Property removed from your wishlist!");
            } else {
                wishlist.push(propertyId);
                alert("Property added to your wishlist!");
            }

            saveWishlist(wishlist);
            updateWishlistButtons();
        }
    });

    updateWishlistButtons();
});
