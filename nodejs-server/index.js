var fs = require("fs");
// var pkey = fs.readFileSync('/etc/letsencrypt/live/example.com/privkey.pem');
// var pcert = fs.readFileSync('/etc/letsencrypt/live/example.com/fullchain.pem')

// var options = {
//   key: pkey,
//   cert: pcert
// };

// var app = require('https').createServer(options);

var app = require("http").createServer(function(req, res) {
  if (req.method === "OPTIONS") {
    console.log("!OPTIONS");
    var headers = {};
    // IE8 does not allow domains to be specified, just the *
    // headers["Access-Control-Allow-Origin"] = req.headers.origin;
    headers["Access-Control-Allow-Origin"] = "*";
    headers["Access-Control-Allow-Methods"] = "POST, GET, PUT, DELETE, OPTIONS";
    headers["Access-Control-Allow-Credentials"] = false;
    headers["Access-Control-Max-Age"] = "86400"; // 24 hours
    headers["Access-Control-Allow-Headers"] =
      "X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept";
    res.writeHead(200, headers);
    res.end();
  }
  // Set CORS headers
  // res.setHeader("Access-Control-Allow-Origin", "*");
  // res.setHeader("Access-Control-Request-Method", "*");
  // res.setHeader("Access-Control-Allow-Methods", "OPTIONS, GET");
  // // res.setHeader("Access-Control-Allow-Headers", "*");
  // res.setHeader("Access-Control-Allow-Headers", req.headers.origin);
  // if (req.method === "OPTIONS") {
  //   res.writeHead(200);
  //   res.end();
  //   return;
  // }
});

// app.all("/*", function(req, res, next) {
//   res.header("Access-Control-Allow-Origin", "*");
//   res.header("Access-Control-Allow-Headers", "X-Requested-With");
//   next();
// });
// app.use(function(req, res, next) {
//   res.header("Access-Control-Allow-Origin", "*");
//   res.header(
//     "Access-Control-Allow-Headers",
//     "Origin, X-Requested-With, Content-Type, Accept-Type"
//   );
//   res.header("Access-Control-Allow-Credentials", "true");
//   next();
// });

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
  console.log("Channel is " + channel + " and message is ", message);
  io.emit(channel, message.data);
});
