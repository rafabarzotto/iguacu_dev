const IncomingForm = require('formidable').IncomingForm;
const fs = require('fs');
const path = require('path');

module.exports = function upload(req, res) {
  var form = new IncomingForm();

  let readStream;

  // store all uploads in the /uploads directory
  form.uploadDir = path.join(__dirname, '../upload');

    // form.on('file', (field, file) => {
    //   // Do something with the file
    //   // e.g. save it to the database
    //   // you can access it using file.path
    //   console.log('file', file.name);
    //   readStream = fs.createReadStream(file.path);
    // });

    var txtName = new Date().toISOString() + '.txt';

    form.on('file', function(field, file) {
      fs.rename(file.path, path.join(form.uploadDir, txtName));
    });

    // log any errors that occur
    form.on('error', function(err) {
      console.log('An error has occured: \n' + err);
    });


    form.on('end', () => {
      res.json();
    });

    form.parse(req);
};
