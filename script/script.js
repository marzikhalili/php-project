const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
});
document.querySelectorAll(".nav-link").forEach((n) => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}));

const searchBox = document.getElementById('search-box');
const startBtn = document.getElementById('start-btn');

// Check if the browser supports the Web Speech API
if (window.SpeechRecognition || window.webkitSpeechRecognition) {
    // Create a new instance of SpeechRecognition
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SpeechRecognition();

    // Set the properties for the SpeechRecognition object
    recognition.lang = 'en-US';
    recognition.continuous = false;
    recognition.interimResults = false;

    // Define what happens when the recognition service starts
    recognition.onstart = function() {
        searchBox.placeholder = "Listening...";
    };

    // Define what happens when the recognition service returns result
    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        searchBox.value = transcript;
        searchBox.placeholder = "Speak and search...";
        // You can also trigger a search function here if you like
        // searchFunction(transcript);
    };

    // Define what happens when the recognition service ends
    recognition.onend = function() {
        searchBox.placeholder = "Speak and search...";
    };

    // Add an event listener to the button to start recognition
    startBtn.addEventListener('click', function() {
        recognition.start();
    });
} else {
    startBtn.disabled = true;
    startBtn.textContent = 'Browser not supported';
}

// Example search function (you can implement it as needed)
function searchFunction(query) {
    // Implement search logic here
    console.log('Searching for:', query);
}

