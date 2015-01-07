/**
 * Created by JohanAlexis on 05/01/2015.
 */
var respuesta="";
$().ready(function()
{
    recuperaSesion();
    $( "#boton" ).click(function( event ) {
        event.preventDefault();
        inicioSesion();
    });
});
function inicioSesion()
{
    var dir = "http://test.balmart.es/rfreenet2/index.php";
    var usuario= $("#usuario").val();
    var pass= $("#pass").val();
    var posting = $.post( dir, {"movil":"1","usuario": usuario,"pass":pass});
    posting.done(function( data )
    {
        //respuesta=data;
        obj= JSON.parse(data);
        if(obj.sesion=='ok')
        {
            guardoSesion(usuario,pass);
            $.mobile.navigate('#mapas');
        } else
        {
            localStorage.clear();
        }
    });
}
function recuperaSesion()
{
    var sesion = window.localStorage.getItem("sesion");
    if (sesion)
    {
        console.log("Entre en recuperaSesion");
    }
}
function guardoSesion(user,pas)
{
    var sesion = { 'usuario' : "'"+user+"'", 'pass' : "'"+pas+"'" };
    localStorage.setItem("sesion",JSON.stringify(sesion));
    salida=JSON.parse(localStorage.getItem('sesion'));
    console.log(salida.pass);
}