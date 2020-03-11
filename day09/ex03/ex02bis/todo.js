var form = $('form');

$(document).ready(function()
{
  makeList();
  form.submit(newTask);
  $('#submit').click(function newTask() {
    console.log("clck");
      var taskIn = prompt("Please enter your todo item", "");
      var list = document.getElementById("ft_list");
      if (taskIn != null) {
        setCookie(taskIn, 1, 1);
        var list_item = document.createElement("li");
        var list_text = document.createTextNode(taskIn);
        list_item.appendChild(list_text);
        list.insertBefore(list_item, list.childNodes[0]);
        list_item.onclick = function()
        {
          var confirmDelete = confirm("Delete this item?");
          if (confirmDelete == true)
          {
            var ttt = this.textContent;
            delCookie(ttt);
            this.parentNode.removeChild(this);
          }
        }
      }
    });
});

function makeList()
{
  var all_cookies = decodeURIComponent(document.cookie);
  var cookie_array = all_cookies.split(";");
  var i = 0;
  var cookieNum = cookie_array.length;
  console.log(cookieNum);
  console.log(cookie_array);
  while (i < cookieNum)
  {
    var cookie = cookie_array[i];
    while(cookie.charAt(0) == ' ')
      cookie = cookie.substring(1);
    var index = cookie.indexOf("=");
    if (index && cookie.substring(0, index) !== "")
      newTask(cookie.substring(0, index));
    i++;
  }
  return "";
}

//makeList();


function getCookie(cookie_name)
{
  var all_cookies = decodeURIComponent(document.cookie);
  var cookie_array = all_cookies.split(";");
  var i = 0;
  var cookieNum = cookie_array.length;
  while (i < cookieNum)
  {
    var cookie = cookie_array[i];
    while(cookie.charAt(0) == ' ')
      cookie = cookie.substring(1);
    if (cookie.indexOf(cookie_name) == 0)
      return cookie.substring(cookie_name.length + 1, cookie.length);
    i++;
  }
  return "";
}

function setCookie(name, value, days)
{
  var exp = new Date();
  exp.setTime(exp.getTime() + (days * 24 * 60 * 60 * 1000));
  document.cookie = name + "=" + value + ";" + "expires=" + exp.toUTCString() + "; path=/";
}

function delCookie(name)
{
  document.cookie = name + "=;" + "expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
}

$('#submit').click(function newTask() {
console.log("clck");
  var taskIn = prompt("Please enter your todo item", "");
  var list = document.getElementById("ft_list");
  if (taskIn != null) {
    setCookie(taskIn, 1, 1);
    var list_item = document.createElement("li");
    var list_text = document.createTextNode(taskIn);
    list_item.appendChild(list_text);
    list.insertBefore(list_item, list.childNodes[0]);
    list_item.onclick = function()
    {
      var confirmDelete = confirm("Delete this item?");
      if (confirmDelete == true)
      {
        var ttt = this.textContent;
        delCookie(ttt);
        this.parentNode.removeChild(this);
      }
    }
  }
});

function newTask(str)
{
  console.log("here");
  if (!str)
    var taskIn = prompt("Please enter your todo item", "");
  else
    var taskIn = str;
  var list = document.getElementById("ft_list");
  if (taskIn != null) {
    setCookie(taskIn, 1, 1);
    var list_item = document.createElement("li");
    var list_text = document.createTextNode(taskIn);
    list_item.appendChild(list_text);
    list.insertBefore(list_item, list.childNodes[0]);
    list_item.onclick = function()
    {
      var confirmDelete = confirm("Delete this item?");
      if (confirmDelete == true)
      {
        var ttt = this.textContent;
        delCookie(ttt);
        this.parentNode.removeChild(this);
      }
    }
  }
}
