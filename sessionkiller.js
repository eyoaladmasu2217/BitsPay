let autoLogoutTime= 1800*1000;
let logoutTimer;

function startAutologoutTimer(){
    logoutTimer = setTimeout(()=>{
        window.location.href ="/BitsPay/index.php?session_expired=1";
    }, autoLogoutTime);
    }
    function resetTimer(){
        clearTimeout(logoutTimer);
        startAutologoutTimer();
    }
window.onload = startAutologoutTimer;
document.onmousemove = resetTimer;
document.onkeypress = resetTimer;
document.onscroll = resetTimer;
document.onclick = resetTimer;