
jQuery(document).ready(function() {
  $("#outra_forma").fadeOut();

  $("#outro").click(function(){
    $("#outra_forma").fadeIn();
  });

  $("#r4").click(function(){
    $("#outra_forma").fadeOut();
  });
  $("#r5").click(function(){
    $("#outra_forma").fadeOut();
  });
  $("#r7").click(function(){
    $("#outra_forma").fadeOut();
  });


  $("#cad").submit(function(){

    var names = ["nome","data","telefone","celular","cidade","uf","rg","cpf","cep","email","pai","mae"];

    var dado_radio = $(this).find('input[name=radio]:checked').val();
    var dado_concordo = $(this).find('input[name=concordo]:checked').val();

    if(
          (dado_radio == "outro") &&
          ($(this).find('input#outra_forma_contri').val() == '')
      ){
          document.getElementById("aviso").click();
          return false;
       }
       else{
          if((typeof dado_concordo === 'undefined') || (typeof dado_radio === 'undefined')){
            document.getElementById("aviso").click();
            return false;
          }else{
              var i;
              for	(i = 0; i < names.length; i++) {
                  var dado = $(this).find("input#"+names[i]).val();
                  if(dado==''){
                      document.getElementById("aviso").click();
                      return false;
                  }
              }
            }
          }

  });

});
