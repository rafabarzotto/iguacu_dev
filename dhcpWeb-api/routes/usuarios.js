var express = require('express');
var App = express.Router();
var Usuarios = getmodule('api/usuarios');


/* GET home page. */
App.route('/usuarios')
	.get(Usuarios.read)
	.post(Usuarios.create);


App.route('/usuarios/:id')
	.get(Usuarios.profile)
	.put(Usuarios.update)
	.delete(Usuarios.delete);

module.exports = App;
