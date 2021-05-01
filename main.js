function validateForm() {
    var x = document.forms["loginForm"]["fname"].value;
    var y = document.forms["loginForm"]["fpassword"].value;
    if ((x == "")||(y == "")) {
      alert("Please do not leave the fields empty");
      return false;
    }
}
function validateCForm() {
    var x = document.forms["createForm"]["cname"].value;
    var y = document.forms["createForm"]["cpassword"].value;
    if ((x == "")||(y == "")) {
      alert("Please do not leave the fields empty");
      return false;
    }
}
function validateFCForm() {
    var x = document.forms["ADCForm"]["fcname"].value;
    var y = document.forms["ADCForm"]["fcpassword"].value;
    var a = document.forms["ADCForm"]["fullname"].value;
    var b = document.forms["ADCForm"]["ad1"].value;
    var c = document.forms["ADCForm"]["city"].value;
    var d = document.forms["ADCForm"]["country"].value;
    var e = document.forms["ADCForm"]["postcode"].value;
    if ((x == "")||(y == "")||(a == "")||(b == "")||(c == "")||(d == "")||(e == "")) {
      alert("Please do not leave the fields empty");
      return false;
    }
    // add the new user to database directly
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var success = xmlhttp.responseText;     
            if (success=="NOTsuccess"){
              alert(success);
              return false;
            }
        }
    }
    xmlhttp.open("POST", "create.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=fastcsubmit&cname="+x+"&cpassword="+y);
}

function moveoutCheckDuplicate(event){
    inputed = event.target.value;
    //check if the account already exists
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        var redWarningSpan = document.getElementById("redWarningSpan");
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var success = xmlhttp.responseText;     
            if (success=="NOTsuccess"){
              redWarningSpan.style.visibility = 'visible';
            }
            else{
              redWarningSpan.style.visibility = 'hidden';
            }
        }
    }
    xmlhttp.open("POST", "create.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=checkcsubmit&cname="+inputed);
}

function validateFCFormLGED() {
    var a = document.forms["ADCForm"]["fullname"].value;
    var b = document.forms["ADCForm"]["ad1"].value;
    var c = document.forms["ADCForm"]["city"].value;
    var d = document.forms["ADCForm"]["country"].value;
    var e = document.forms["ADCForm"]["postcode"].value;
    if ((a == "")||(b == "")||(c == "")||(d == "")||(e == "")) {
      alert("Please do not leave the fields empty");
      return false;
    }
}

// function showAll() {
//   console.log('show all fired');
//   var xmlhttp = new XMLHttpRequest();
      
//   xmlhttp.onreadystatechange = function () {
//     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//       var mainShowBookArea = document.getElementById("mainShowBookArea");
//       mainShowBookArea.innerHTML = xmlhttp.responseText;
//       console.log('process done and get',xmlhttp.responseText);
//       console.log('or is displayed at:',mainShowBookArea.innerHTML);
//     }
//   }
//   xmlhttp.open("POST", "showbook.php", true);
//   xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   xmlhttp.send("show=all");
// }

function randomtesting(){
  console.log('testing all fired');
}

console.log('linked but other not shown');
showAll();
randomtesting();
window.onload = function() {
  console.log('fired');
  showAll();
}
// document.getElementById("majBtn").addEventListener('click', filterM);