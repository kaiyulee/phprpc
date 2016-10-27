var thrift = require('thrift');
var ThriftTransports = require('thrift/transport');
var ThriftProtocols = require('thrift/protocol');
var Book = require('../gen-nodejs/Book');
var ttypes = require('../gen-nodejs/book_types');

transport = ThriftTransports.TFramedTransport;
protocol = ThriftProtocols.TBinaryProtocol;

var connection = thrift.createConnection("localhost", 8095, {
    transport : transport,
    protocol : protocol
});

connection.on('error', function (err) {
    console.log(err);
});

// Create a Book client with the connection
var client = thrift.createClient(Book, connection);

client.getBookInfo(1, function (err, data) {
    if (err) {
        console.log("InvalidOperation " + err);
    } else {
        console.log(data);
    }
    connection.end();
});
