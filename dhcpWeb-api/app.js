require('getmodule');
var express = require('express');
var logger = require('morgan');
var bodyParser = require('body-parser');
var connection  = require('express-myconnection');
var mysql = require('mysql');
var app = express();
var cors = require('cors');
var path = require('path');
const execSync   = require('child_process').execSync;
const fs = require('fs');

var index = require('./routes/index');
var lembretes = require('./routes/lembretes');
var veiculos = require('./routes/veiculos');
var usuarios = require('./routes/usuarios');
var hosts = require('./routes/hosts');
var dhcpServer = require('./routes/dhcpserver');
var upload = require('./routes/upload');
var updateEstoque = require('./routes/updateEstoque');

app.use(logger('dev'));
app.use(cors());

//app.set('jwtTokenSecret', 'vibevendasehfodapracrlaee');
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use(
    connection(mysql,{
        host: 'localhost',
        user: 'opt',
        password : 'qwe123',
        port : 3306, //port mysql
        //database:'restful_api_demo'
        database:'iguacu'
    },'request')
);

app.use('/', index);
app.use('/', lembretes);
app.use('/', veiculos);
app.use('/', usuarios);
app.use('/', hosts);
app.use('/', dhcpServer);
app.use('/', upload);
app.use('/', updateEstoque);

app.use(function(req, res, next) {
    req.app = app;
    next();
});

if (app.get('env') === 'development') {
    app.use(function(err, req, res, next) {
        res.status(err.status || 500);
        res.json({
            message: err.message,
            error: err
        });
    });
}

// production error handler
// no stacktraces leaked to user
app.use(function(err, req, res, next) {
    res.status(err.status || 500);
    res.json({
        message: err.message,
        error: {}
    });
});

module.exports = app;
