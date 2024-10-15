//ESTO ES UNA FUNCIÓN AÚN POR IMPLEMENTAR
//SE UTILIZARÁ PARA EL INICIO DE SESIÓN POR GOOGLE
function handleCredentialResponse(response) {
    const token = response.credential;
    console.log("Token JWT recibido:", token);

    //Enviamos el token al servidor para verificarlo
    fetch('php/verify_token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: token })
    }).then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('user-info').innerText = `Bienvenido, ${data.email}`;
            } else {
                document.getElementById('user-info').innerText = `Acceso denegado: ${data.message}`;
            }
        })
    .catch(error => console.error('Error al verificar el token:', error));
}