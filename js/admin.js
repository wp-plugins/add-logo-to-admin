window.onload = addLogo;

function addLogo() {
	var myBody = document.getElementById("wphead").getElementsByTagName("a")[0];
	myBody.innerHTML = "";

	var img = document.createElement("img");
	var imgSrc = "../wp-content/plugins/add-logo-to-admin/images/logo.png";
	img.setAttribute("src",imgSrc);
	img.setAttribute("id", "newLogo");
	
	myBody.appendChild(img);
	return false;
}