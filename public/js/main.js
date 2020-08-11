var categorySelect = document.getElementById("category");
var concertSubcatDiv = document.getElementById("concertSubcat");
var exhibitionSubcatDiv = document.getElementById("exhibitionSubcat");
var conferenceSubcatDiv = document.getElementById("conferenceSubcat");
var hackathonSubcatDiv = document.getElementById("hackathonSubcat");
var gamejamSubcatDiv = document.getElementById("gamejamSubcat");

var metalCheckbox = document.getElementById("metal");
var classicCheckbox = document.getElementById("classic");
var edmCheckbox = document.getElementById("edm");

var contemporaryArtCheckbox = document.getElementById("contemporary_art");
var photographyCheckbox = document.getElementById("photography");
var historicalCheckbox = document.getElementById("historical");

var politicalCheckbox = document.getElementById("political");
var environmentalCheckbox = document.getElementById("environmental");
var educationalCheckbox = document.getElementById("educational");

var musicalCheckbox = document.getElementById("musical");
var environmental2Checkbox = document.getElementById("environmental2");
var socialCheckbox = document.getElementById("social");

var fpsCheckbox = document.getElementById("fps");
var rpgCheckbox = document.getElementById("rpg");
var mobaCheckbox = document.getElementById("moba");

categorySelect.addEventListener('change', event => {
    metalCheckbox.checked = false;
    classicCheckbox.checked = false;
    edmCheckbox.checked = false;

    contemporaryArtCheckbox.checked = false;
    photographyCheckbox.checked = false;
    historicalCheckbox.checked = false;

    politicalCheckbox.checked = false;
    environmentalCheckbox.checked = false;
    educationalCheckbox.checked = false;

    musicalCheckbox.checked = false;
    environmental2Checkbox.checked = false;
    socialCheckbox.checked = false;

    fpsCheckbox.checked = false;
    rpgCheckbox.checked = false;
    mobaCheckbox.checked = false;

    switch (categorySelect.value)
    {
        case "1":
            concertSubcatDiv.style.display = "block";
            exhibitionSubcatDiv.style.display = "none";
            conferenceSubcatDiv.style.display = "none";
            hackathonSubcatDiv.style.display = "none";
            gamejamSubcatDiv.style.display = "none";
            break;
        case "2":
            concertSubcatDiv.style.display = "none";
            exhibitionSubcatDiv.style.display = "block";
            conferenceSubcatDiv.style.display = "none";
            hackathonSubcatDiv.style.display = "none";
            gamejamSubcatDiv.style.display = "none";
            break;
        case "3":
            concertSubcatDiv.style.display = "none";
            exhibitionSubcatDiv.style.display = "none";
            conferenceSubcatDiv.style.display = "block";
            hackathonSubcatDiv.style.display = "none";
            gamejamSubcatDiv.style.display = "none";
            break;
        case "4":
            concertSubcatDiv.style.display = "none";
            exhibitionSubcatDiv.style.display = "none";
            conferenceSubcatDiv.style.display = "none";
            hackathonSubcatDiv.style.display = "block";
            gamejamSubcatDiv.style.display = "none";
            break;
        case "5":
            concertSubcatDiv.style.display = "none";
            exhibitionSubcatDiv.style.display = "none";
            conferenceSubcatDiv.style.display = "none";
            hackathonSubcatDiv.style.display = "none";
            gamejamSubcatDiv.style.display = "block";
            break;
    }
});

