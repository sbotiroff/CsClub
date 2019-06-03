//holds everything until page is loaded
window.addEventListener("load", function () {
	var load_screen = document.getElementById("load_screen");
	document.body.removeChild(load_screen);
	document.querySelector('header').classList.add("fadeIn");
	homeAnimations();
	navBackgroundAdd();
	
});

//calling functions when window scroll
window.onscroll = function () {
	navScrollColorAdd();
	animatedElementRemover();
}

// function for changing color of navigation.
function navScrollColorAdd() {
	var nav = document.getElementById("nav");
	if (document.querySelector(".full-main")) {
		if (window.pageYOffset > 7) {
			nav.style.background = "rgba(23, 36, 48,0.95)";
			nav.style.boxShadow = "0px 1px 10px rgba(0,0,0,0.9)";
			nav.style.position = "fixed";
		} else {
			nav.style.background = "rgba(0, 0, 0, .30)";
			nav.style.boxShadow = "0 0 1rem 0 rgba(0, 0, 0, .2)";
		}
	} else {
		if (window.pageYOffset > 7) {
			nav.style.background = "rgba(23, 36, 48,0.95)";
			nav.style.boxShadow = "0px 1px 10px rgba(0,0,0,0.9)";
			nav.style.position = "fixed";
		} else {
			nav.style.background = "rgb(55, 66, 77)";
			nav.style.boxShadow = "0 0 1rem 0 rgba(0, 0, 0, .2)";
		}
	}
}

//adding different color if main class not .full-main
function navBackgroundAdd() {
	if (!document.querySelector(".full-main")) {
		var nav = document.getElementById("nav");
		nav.style.background = "rgb(39,45,51)";
		nav.style.boxShadow = "0px 1px 10px rgba(0,0,0,0.9)";
	}
}

function animatedElementRemover() {
		
	const childH2Header = document.querySelector('.home-header > h2');
	if (childH2Header) {
		if (window.pageYOffset > 212) {
			childH2Header.classList.remove("flipInX");
			childH2Header.classList.add("fadeOut");
			return;
		}

		childH2Header.classList.remove("fadeOut");
		childH2Header.classList.add("flipInX");
	}
}

//adding animations for home page
function homeAnimations() {
	if (document.querySelector('.home-header > h2')) {
		document.querySelector('.home-header > h2').classList.add("flipInX");
		document.querySelector('.home-header').classList.add("pulse");
	}
}

