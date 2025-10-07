// Function to open the popup
function openPopup() {
    document.body.classList.add('noscroll');
    popupOverlay.style.display = 'block';
}

// Function to close the popup
function closePopup() {
    popupOverlay.style.display = 'none';
    document.body.classList.remove('noscroll');
}

document.addEventListener('DOMContentLoaded', function () {
    const popupOverlay = document.getElementById('popupOverlay');
    const popup = document.getElementById('popup');
    const closePopupButton = document.getElementById('closePopup');
    // const emailInput = document.getElementById('emailInput');

    // Function to submit the signup form
    // function submitForm() {
    //     const email = emailInput.value;
    //     // Add your form submission logic here
    //     console.log(`Email submitted: ${email}`);
    //     closePopup(); // Close the popup after form submission
    // }

    // Event listeners

    // Trigger the popup to open (you can call this function on a button click or any other event)
    // openPopup();

    // Close the popup when the close button is clicked
    closePopupButton.addEventListener('click', closePopup);

    // Close the popup when clicking outside the popup content
    popupOverlay.addEventListener('click', function (event) {
        if (event.target === popupOverlay) {
            closePopup();
        }
    });
});