function sendEmail() {
  var sheet = SpreadsheetApp.getActive().getSheetByName('Sheet1'); // ganti 'Sheet1' dengan nama sheet Anda
  var startRow = sheet.getLastRow(); // memulai dari row paling baru
  var numRows = sheet.getLastRow() - startRow + 1; // hitung jumlah baris yang akan dicek
  var dataRange = sheet.getRange(startRow, 1, numRows, sheet.getLastColumn());
  var data = dataRange.getValues();
  
  var emailAddress = "emailtesarduino@gmail.com";
  var subject = "WARNING SUHU RUANGAN SERVER MELEBIHI 32°C";
  
  for (var i = 0; i < data.length; i++) {
    var row = data[i];
    var cValue = row[2]; // ambil nilai pada kolom C
    if (cValue >= 32) {
      MailApp.sendEmail(emailAddress, subject, cValue);
    }
  }
}

