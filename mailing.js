const msg_error="Something went wrong!";
document.getElementById("getintouch").addEventListener("submit", function(e) {
    e.preventDefault();
   var data =new FormData(this);
    var xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function()
    {
      if (this.readyState == 4 && this.status == 200)
      {

            
            var res=this.response;
             if(res.success)
             {    swal({
                title: "Good job!",
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
    xhr.open("post" ,"sendEmail.php",true);
    xhr.responseType="json";
    xhr.send(data);
   return false;
});
