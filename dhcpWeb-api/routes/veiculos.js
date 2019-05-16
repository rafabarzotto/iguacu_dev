var express = require('express');
var App = express.Router();
var Veiculos = getmodule('api/veiculos');


/* GET home page. */
App.route('/veiculos')
	.get(Veiculos.read)
	.post(Veiculos.create);


App.route('/veiculos/:id')
	.get(Veiculos.profile)
	.put(Veiculos.update)
	.delete(Veiculos.delete);


module.exports = App;
