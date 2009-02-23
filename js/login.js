var oldOnload = window.onload;

if(typeof oldOnload == "function") {
	window.onload = function() {
		if(oldOnload) {
			oldOnload();
		}
		addLogo();
	}
} else {
	window.onload = addLogo;
}

function addLogo() {
	var myBody = document.getElementById("login").getElementsByTagName("h1")[0];
	myBody.innerHTML = "";

	var img = document.createElement("img");
	var imgSrc = newLogo.site+newLogo.logo;
	img.setAttribute("src",imgSrc);
	img.setAttribute("id", "newLogo");
	
	myBody.appendChild(img);
	
	myBody.style.display = "block";
	
	return false;
}