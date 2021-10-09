const msg_error="Something went wrong!";
document.getElementById("getintouch").addEventListener("submit", function(e) {
    e.preventDefault();
    var xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function()
    {
      if (this.readyState == 4 && this.status == 201)
      {
            var res=this.response;
             if(res.message)
             {    swal({
                title: "Mail sent successfully",
                text: res.msg,
                icon: "success",
              });

             }else
             {
                swal("Oops!",res.msg, "error");


             }
      }else if(this.readyState == 4 ){
        swal("Oops!", msg_error, "error");

      }
    };
    xhr.open("post" ,"https://harmony-digital.herokuapp.com/api/mail",true);
    xhr.responseType="json";
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.send(JSON.stringify({email:document.getElementById('email').value}));
   return false;
});

