var socket = io.connet('http://192.168.253.131:8080',{'forceNew':true});

socket.on('connect',function(soc){
	var user = {
		id:socket.sessionid,
		username:'100',
		session:socket.cookiesessionid
	};
	socket.emit('app_user',user);
});