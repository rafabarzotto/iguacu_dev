exports.read = function(req, res) {
	req.getConnection(function(err, connection) {
		connection.query('SELECT * FROM dhcpClient', [], function(err, result) {
			if (err) return res.status(400).json();

			return res.status(200).json(result);
		});
	});
}


exports.create = function(req, res) {
	var data = req.body;

	req.getConnection(function(err, connection) {
		connection.query('INSERT INTO dhcpClient SET ?', [data], function(err, result) {
			if (err) return res.status(400).json(err);

			return res.status(200).json(result);
		});
	});
}


exports.profile = function(req, res) {
	var id = req.params.id;

	req.getConnection(function(err, connection) {
		connection.query('SELECT * FROM dhcpClient WHERE id = ?', [id], function(err, result) {
			if (err) return res.status(400).json(err);

			return res.status(200).json(result[0]);
		});
	});
}

exports.update = function(req, res) {
	var data = req.body,
		id = req.params.id;

	req.getConnection(function(err, connection) {
		connection.query('UPDATE dhcpClient SET ? WHERE id = ? ', [data, id], function(err, result) {
			if (err) return res.status(400).json(err);

			return res.status(200).json(result);
		});
	});
}

exports.delete = function(req, res) {
	var id = req.params.id;

	req.getConnection(function(err, connection) {
		connection.query('DELETE FROM dhcpClient WHERE id = ? ', [id], function(err, result) {
			if (err) return res.status(400).json(err);

			return res.status(200).json(result);
		});
	});
}


exports.qtdTipo = function(req, res) {
	req.getConnection(function(err, connection) {
		connection.query('SELECT count(tipo) AS qtd, tipo FROM dhcpClient GROUP BY tipo;', [], function(err, result) {
			if (err) return res.status(400).json();

			return res.status(200).json(result);
		});
	});
}

exports.dash = function(req, res) {
	req.getConnection(function(err, connection) {
		connection.query('SELECT sum(case when mac_address IS NOT NULL then 1 else 0 end) qtdMacCad, sum(case when descricao LIKE "LIVRE" then 1 else 0 end) qtdIpLivre, sum(case when status_dhcp = "1" then 1 else 0 end) qtdDhcpCad FROM dhcpClient;', [], function(err, result) {
			if (err) return res.status(400).json();

			return res.status(200).json(result);
		});
	});
}

exports.dropdownFaixaIp = function(req, res) {
	req.getConnection(function(err, connection) {
		connection.query('SELECT LEFT(ip_address, 10) AS faixa FROM dhcpClient GROUP BY LEFT(ip_address, 10);', [], function(err, result) {
			if (err) return res.status(400).json();

			return res.status(200).json(result);
		});
	});
}


exports.filter = function(req, res) {

	var faixa = req.params.faixa + '%';

	console.log(faixa);

	req.getConnection(function(err, connection) {
		connection.query('SELECT * FROM dhcpClient WHERE ip_address LIKE ?;', [faixa], function(err, result) {
			if (err) return res.status(400).json(err);

			return res.status(200).json(result);
		});
	});
}