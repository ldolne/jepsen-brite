var Payment1 = document.getElementById("Payment1");
var BCO = document.getElementById("BCO");

Payment1.addEventListener('change', event => {
    BCO.style.display = Payment1.value == "A/C" ? "block" : "none";
});

