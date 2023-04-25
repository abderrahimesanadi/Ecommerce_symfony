

function removeFromPanier(product_id) {
    let p_i = document.querySelector("#product_"+product_id) ;
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("Accept", "application/json");
    
    var myInit = { method: 'GET',
                  headers: myHeaders,
                 };
    var path =  "/panier/remove/"+ product_id;         
    var myRequest = new Request(path,myInit);
    /*myRequest.json().then((data) => {
      console.log(data);
      response.json()).then((data) =>
   });*/

   fetch(myRequest,myInit).then((response) =>  {   
           console.log(response);   
           path = "/panier/total"; 
           myRequest = new Request(path,myInit);
           fetch(myRequest,myInit).then((response) => response.json()).then((data) => {
             let s_t = document.querySelector("#total") ;
             s_t.innerText = data + "  Dhs";
             p_i.remove();
       
    }).catch(function(e){
       console.log("Erreur");
       alert(e);
    });
   });
}