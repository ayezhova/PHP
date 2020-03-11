function formClick(evt, formRequested)
{
    var i = 0;
    var tabcontents;
    var tabs;
    
    tabconents = document.getElementsByClassName("inTab");
    while (i < 3)
    {
        tabcontents[i].style.display = "none";
        i++;
    }
    
    tabs = document.getElementsByClassName("tab");
    i = 0;
    while (i < 3)
    {
        tabs[i].style.display = "none";
        i++;
    }
    document.getElementById(formRequested).style.display = "block";
    evt.currentTarget.className += "active";
    
}