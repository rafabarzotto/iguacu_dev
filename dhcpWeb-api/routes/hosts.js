var express = require('express');
var App = express.Router();
var Hosts = getmodule('api/hosts');


/* GET home page. */
App.route('/hosts')
	.get(Hosts.read)
	.post(Hosts.create);

App.route('/hosts/dash')
	.get(Hosts.dash);

App.route('/hosts/qtdtipo')
	.get(Hosts.qtdTipo);

App.route('/hosts/dropdownfaixaIp')
	.get(Hosts.dropdownFaixaIp);

App.route('/hosts/:id')
	.get(Hosts.profile)
	.put(Hosts.update)
	.delete(Hosts.delete);

App.route('/hosts/faixa/:faixa')
	.get(Hosts.filter);

module.exports = App;