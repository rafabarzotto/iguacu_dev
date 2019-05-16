var express = require('express');
var App = express.Router();
var dhcpServer = getmodule('api/dhcpserver');


/* GET home page. */
App.route('/dhcpserver/service')
	.get(dhcpServer.service);

App.route('/dhcpserver/start')
	.get(dhcpServer.start);

App.route('/dhcpserver/stop')
	.get(dhcpServer.stop);

App.route('/dhcpserver/restart')
	.get(dhcpServer.restart);

App.route('/dhcpserver/status')
	.get(dhcpServer.status);

module.exports = App;