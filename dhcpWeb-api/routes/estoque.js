var express = require('express');
var App = express.Router();
var Estoque = getmodule('api/estoque');


/* GET home page. */
App.route('/estoque')
	.get(Estoque.read)
	.post(Estoque.create);


App.route('/estoque/:id')
	.get(Estoque.profile)
	.put(Estoque.update)
	.delete(Estoque.delete);


module.exports = App;
