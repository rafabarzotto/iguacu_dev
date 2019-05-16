const fs = require('fs');

console.log('1');

module.exports = function updateEstoque(req, res) {
  console.log('entrou');

  fs.readFile('upload/teste.txt', 'utf8', function(err, contents) {
      console.log(contents);
      console.log(err);
  });

  console.log('after calling readFile');
};
