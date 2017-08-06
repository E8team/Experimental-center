// JavaScript Document
window.onload = function() {
    var oDiv = document.getElementById("tab");
    var oLi = oDiv.getElementsByTagName("div")[0].getElementsByTagName("li");
    var aCon = oDiv.getElementsByTagName("div")[1].getElementsByTagName("div");
    var timer = null;
    for (var g = 0; g < oLi.length; g++) {
        oLi[g].index = g;
        oLi[g].onclick = function() {
            show(this.index);
        }
    }
    function show(b) {
        index = b;
        var alpha = 0;
        for (var k = 0; k < oLi.length; k++) {
            oLi[k].className = "";
            aCon[k].className = "";
            aCon[k].style.opacity = 0;
            aCon[k].style.filter = "alpha(opacity=0)";
        }
        oLi[index].className = "cur";
        clearInterval(timer);
        timer = setInterval(function() {
            alpha += 2;
            alpha > 100 && (alpha = 100);
            aCon[index].style.opacity = alpha / 100;
            aCon[index].style.filter = "alpha(opacity=" + alpha + ")";
            alpha == 100 && clearInterval(timer);
        },
        5)
    }
}