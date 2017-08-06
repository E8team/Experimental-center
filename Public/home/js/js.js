window.onload = function() {

    var value = 100;

    var oDiv = document.getElementById("tab");
	var oDiv2 = document.getElementById("tab1");
		
    var oLi = oDiv.getElementsByTagName("div")[0].getElementsByTagName("li");
	var oLi2 = oDiv2.getElementsByTagName("div")[0].getElementsByTagName("li");
	
    var aCon = oDiv.getElementsByTagName("div")[1].getElementsByTagName("div");
	var aCon2 = oDiv2.getElementsByTagName("div")[1].getElementsByTagName("div");
	
    var timer = null;
	var timer2 = null;
    for (var i = 0; i < oLi.length; i++) {
        oLi[i].index = i;
        oLi[i].onclick = function() {
            show(this.index);
        }
    }
	
	for (var i = 0; i < oLi2.length; i++) {
        oLi2[i].index = i;
        oLi2[i].onclick = function() {
            show2(this.index);
        }
    }
	
    function show(a) {
        index = a;
        var alpha = 0;
        for (var j = 0; j < oLi.length; j++) {
            oLi[j].className = "";
            aCon[j].className = "zindex_1";
            aCon[j].style.opacity = 0;
            aCon[j].style.filter = "alpha(opacity=0)";
        }
        oLi[index].className = "cur";
        clearInterval(timer);
        timer = setInterval(function() {
            alpha += 2;
            alpha > 100 && (alpha = 100);
            aCon[index].style.opacity = alpha / 100;
            aCon[index].style.filter = "alpha(opacity=" + alpha + ")";
            aCon[index].className = "zindex";
            alpha == 100 && clearInterval(timer);
        },
        5)
    }
	
	function show2(a){
		index = a;
        var alpha = 0;
        for (var j = 0; j < oLi2.length; j++) {
            oLi2[j].className = "";
            aCon2[j].className = "zindex_1";
            aCon2[j].style.opacity = 0;
            aCon2[j].style.filter = "alpha(opacity=0)";
        }
        oLi2[index].className = "cur";
        clearInterval(timer);
        timer2 = setInterval(function() {
            alpha += 2;
            alpha > 100 && (alpha = 100);
            aCon2[index].style.opacity = alpha / 100;
            aCon2[index].style.filter = "alpha(opacity=" + alpha + ")";
            aCon2[index].className = "zindex";
            alpha == 100 && clearInterval(timer2);
        },
		5)
	}
}