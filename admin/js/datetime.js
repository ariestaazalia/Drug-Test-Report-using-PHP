var dt = new Date();
    var weekday = new Array(7);
        weekday[0] = "Minggu";
        weekday[1] = "Senin";
        weekday[2] = "Selasa";
        weekday[3] = "Rabu";
        weekday[4] = "Kamis";
        weekday[5] = "Jum'at";
        weekday[6] = "Sabtu";
    document.getElementById("datetime").innerHTML = 
    (weekday[dt.getDay()]) +", "+ 
    (("0"+dt.getDate()).slice(-2)) +"."+ 
    (("0"+(dt.getMonth()+1)).slice(-2)) +"."+ 
    (dt.getFullYear()) +" / "+ 
    (("0"+dt.getHours()).slice(-2)) +":"+ 
    (("0"+dt.getMinutes()).slice(-2));