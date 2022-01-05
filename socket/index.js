var app = require('express')();
var http = require('http').Server(app);

var io = require('socket.io')(8081);
io.set('origins', ['taodalin.com:*','m.taodalin.com:*','www.taodalin.com:*']);
var mysql = require('mysql');
var port =3000;
var con = mysql.createConnection({
  host: "127.0.0.1",
  user: "root",
  password: "!@#123qweQWE!90",
  database: "buy",
  port:3306
});
con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});


io.on('connection', function(socket){

  socket.on('chat message', function(msg1,msg2,msg3,msg4,msg5){

    io.emit('chat message', msg1,msg2,msg3,msg4,msg5);
    var sql = "INSERT INTO tbl_notice (type, content, userId,tt) VALUES ('"+msg1+"', '"+msg2+"', '"+msg3+"','"+msg4+"')";
    con.query(sql, function (err, result) {
      if (err) throw err;
    });
  });
});

