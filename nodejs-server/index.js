var fs = require("fs");
// var pkey = fs.readFileSync('/etc/letsencrypt/live/example.com/privkey.pem');
// var pcert = fs.readFileSync('/etc/letsencrypt/live/example.com/fullchain.pem')

// var options = {
//   key: pkey,
//   cert: pcert
// };

// var app = require('https').createServer(options);
var app = require("http").createServer();

var io = require("socket.io")(app);

var Redis = require("ioredis");

var redis = new Redis();

app.listen(9000, function() {
  console.log("Server is running!");
});

function handler(req, res) {
  res.setHeader("Access-Control-Allow-Origin", "*");
  res.writeHead(200);
  res.end("");
}

io.on("connection", function(socket) {
  //
});

redis.psubscribe("*", function(err, count) {
  //
});

redis.on("pmessage", function(subscribed, channel, message) {
  message = JSON.parse(message);
  console.log("Channel is " + channel + " and message is " + message);
  io.emit(channel, message.data);
});
