exports.service = function(req, res) {

	var exec = require('child_process').exec;

	exec('ps aux | grep dhcpd | grep -v "grep"', function(err, stdout, stderr) {
		is_running = 0;

		var result = stdout.split("\n");
		for (var i = 0; i < result.length; i++) {
			if (/dhcpd/i.test(result[i])) {
				is_running = 1;
			}
			// console.log('line ' + result[i]);
		}

		var return_content = "";

		if (is_running) {
			return_content = 'DHCP Server Ligado!';
		} else {
			return_content = 'DHCP Server Desligado!';
		}

		res.send(return_content);

	});

}

exports.start = function(req, res) {

	var exec = require('child_process').exec;

	exec('echo -e "qwe123\n" | sudo -S /etc/init.d/isc-dhcp-server start', function(err, stdout, stderr) {

		res.send('DHCP Server Ligado!');

	});

}

exports.stop = function(req, res) {

	var exec = require('child_process').exec;

	exec('echo -e "qwe123\n" | sudo -S /etc/init.d/isc-dhcp-server stop', function(err, stdout, stderr) {

		res.send('DHCP Server Desligado!');

	});

}

exports.restart = function(req, res) {

	var exec = require('child_process').exec;

	exec('echo -e "qwe123\n" | sudo -S /etc/init.d/isc-dhcp-server restart', function(err, stdout, stderr) {

		res.send('DHCP Server Ligado!');

	});

}

exports.status = function(req, res) {

	var exec = require('child_process').exec;

	exec('echo -e "qwe123\n" | sudo -S /etc/init.d/isc-dhcp-server status', function(err, stdout, stderr) {

		is_running = 0;

		var result = stdout.split("\n");
		for (var i = 0; i < result.length; i++) {
			if (result[i].indexOf('running') != -1) {
				is_running = 1;
			}
			// console.log('line ' + result[i]);
		}

		var return_content = "";

		if (is_running) {
			return_content = 'DHCP Server Ligado!';
		} else {
			return_content = 'Falha ao Iniciar - Erro no Arquivo /etc/dhcpd.conf';
		}

		res.send(return_content);

		//res.send(stdout);

	});

}