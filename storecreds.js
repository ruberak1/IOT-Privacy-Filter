var today = new Date();
var expiry = new Date(today.getTime() + 30 * 24 * 3600 * 1000); // plus 30 days

function setCookie(name, value)
{
  document.cookie=name + "=" + escape(value) + "; path=/; expires=" + expiry.toGMTString();
}
function storeValues(loginForm)  
  {
    setCookie("username", loginForm.unameInput.value);
    setCookie("password", loginForm.passInput.value);
//	if (validateForm()){
//		return true;
//	}else{
//		return false;
//	}
  }