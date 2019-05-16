var express = require('express');
var App = express.Router();
var Lembretes = getmodule('api/lembretes');


/* GET home page. */
App.route('/lembretes')
	.get(Lembretes.read)
	.post(Lembretes.create);


App.route('/lembretes/:id')
	.get(Lembretes.profile)
	.put(Lembretes.update)
	.delete(Lembretes.delete);


module.exports = App;
